<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Sector;
use App\Models\Question;
use App\Models\Rock;
use App\Models\Option;
use App\Models\Grade;
use App\Models\GradeQuestion;
use Illuminate\Support\Str;
use Goutte;


class ImportsController extends Controller
{
    public function categories($sector_id){
        
      $sector=  Sector::find($sector_id);
      if(!$sector)
      	abort(404);
      $categories=  explode(",","Accounting,GST,Economics,Costing,Business and Commerce,Insurance,eCommerce,Financial Management,Capital Market,Demonetisation in India Cooperative Society,Sole Proprietorship,Joint Stock Company,International Trade and Finance,Business Environment,Internal Trade,Marketing Mix,Admission of New Partner,Cost concept,Bill of Exchange,Business Studies,Retirement/Death of a Partner,Balance Sheet,Cash Flow Statement,Trial Balance,Partnership,Statistics,Sustainable Development,Indian Economy,Rural Credit,Globalisation,Debentures,Central Problems of An Economy ,Investment,Ledger Management Accounting,Sampling Methods,Retained Earnings,Law of Demand,Function of Commercial Banks,Commercial Banks,Depreciation,Employee Stock Option Plan,Private Placement Meaning Types,Super Profit Method,Fluctuating Capital Account,Average Profit Method,Capitalisation Method,Functions of Marketing,Concept of Public Relations,Tally ERP,Financial Markets,Capital Markets");

	      foreach($categories as $cat){

				$cat=trim($cat);
				$slug=Str::slug($cat);
				$category=Category::where(['slug'=>$slug])->first();
				if(!$category){

					$category= new Category;
					$category->name=$cat;
					$category->sector_id=$sector_id;
					$category->slug=$slug;
					$category->status=1;
					$category->save();


				}

	      }
	      


    }

public function importfromOiq($category_id,$quiz_id){


	$content=file_get_contents("https://www.onlineinterviewquestions.com/get-all-questions-by-category/".$quiz_id);
	$questions=json_decode($content);
	//dd($questions);


		foreach($questions as $quest){

		
				$slug=strip_tags($quest->title);
				$slug=Str::slug(substr($slug, 0,70));
				$question=Question::where(['slug'=>$slug])->first();
								if(!$question){

										$question=new Question;
										$question->name=$quest->title;
										$question->slug=$slug;
										$question->category_id=$category_id;
										$question->save();

										if($quest->option1){
											$option= new Option;
											$option->question_id=$question->id;
											$option->name=trim($quest->option1);
											if($quest->correct_answer==1)
											 $option->answer=1;
											else
											 $option->answer=0;
											$option->save();

										}
									if($quest->option2){
											$option= new Option;
											$option->question_id=$question->id;
											$option->name=trim($quest->option2);
											if($quest->correct_answer==2)
											 $option->answer=1;
											else
											 $option->answer=0;
											$option->save();

										}

										if($quest->option3){
											$option= new Option;
											$option->question_id=$question->id;
											$option->name=trim($quest->option3);
											if($quest->correct_answer==3)
											 $option->answer=1;
											else
											 $option->answer=0;
											$option->save();

										}

										if($quest->option4){
											$option= new Option;
											$option->question_id=$question->id;
											$option->name=trim($quest->option4);
											if($quest->correct_answer==4)
											 $option->answer=1;
											else
											 $option->answer=0;
											$option->save();

										}
										//dd($question);



						}

}

}




public function importFromIm(Request $request){

	    $category_id=$request->category_id;
		$quiz_id   =$request->slug;

		$this->importfromOiq($category_id,$quiz_id);

		

		$content=file_get_contents("http://quiz.interviewmocks.com/api/get-all-questions-by-category/".$quiz_id);

		$questions=json_decode($content);

		//dd($questions);

		foreach($questions as $quest){

		
				$slug=strip_tags($quest->title);
				$slug=Str::slug(substr($slug, 0,70));
				$question=Question::where(['slug'=>$slug])->first();
								if(!$question){

										$question=new Question;
										$question->name=$quest->title;
										$question->slug=$slug;
										$question->category_id=$category_id;
										$question->save();

										
										
										foreach($quest->question_option as $key=> $opt){
											$option= new Option;
											$option->question_id=$question->id;
											$option->name=trim($opt->option_title);
											if($opt->is_answer)
											 $option->answer=1;
											else
											 $option->answer=0;
											$option->save();
									
										}

										//dd($question);



						}

}


}




public function mcqlearnCron(){
 		$rock= Rock::where(['scraper_id'=>3,'status'=>1])->first();



	   if(!$rock){
	   	 die("No active crons found");
	   }

        $category_id=$rock->category_id;
        $category=Category::find($category_id);
		if(!$category){
			abort(404);
		}

  	   $quizzes = range(1,$rock->pages);	
		foreach($quizzes as $sslug){

			  $quiz_id   =$category_id.'-mcqlearn-'.$sslug;
			  $alreadyScraped=Question::where(['scraper_id'=>$quiz_id])->count();
			  if(!$alreadyScraped){
       			$url=$rock->slug.'?page='.$sslug;

						  $crawler = \Goutte::request('GET', $url);

							$nodeValues[] = $crawler->filter('.mcqcntntdiv')->each(function ($node){

							if($node->filter('p')->count()){

							$q_text=$node->filter('p')->text();
							$post['question']= trim(str_replace("MCQ:", "", $q_text));

							
							
							$post['option']=$node->filter('li')->each(function($optionNode){	

							return	$opt=preg_replace('/\s+/', ' ',str_replace(["\n","\t"],"",$optionNode->text()));
							

								
								
							});
							$answer=$node->filter('.dsplyans')->text();
							
							$temp=["A"=>1,"B"=>2,"C"=>3,"D"=>4];

							$post['answer']=$temp[$answer];
								return $post;
							}

							});


							$questions=[];
							foreach($nodeValues as $key=>$questionslist)
							{
								foreach($questionslist as $value){	
									if($value){
										$questions[]=$value;
										
										
										
									}
								}
							}


				foreach($questions as $data){

					$slug= strip_tags($data['question']);
				    $slug=Str::slug(substr($slug, 0,70));
					
					$question=Question::where(['slug'=> $slug])->first();
					if(!$question){
						
						$question=new Question;
						$question->name=trim($data['question']);
						$question->slug=$slug;
						$question->scraper_id=$quiz_id;
						$question->category_id=$category_id;
						$question->save();



						$i=1;
						foreach($data['option'] as $option){
							$option=preg_replace('/\s+/', ' ',str_replace(["A.","B.","C.","D."],"",$option));
							if(strlen($option)>0 && $option!="" &&  $option!=" "){
								$questionOption=new Option;
								$questionOption->question_id=$question->id;
								$questionOption->name=$option;
								if($i==$data['answer']){
									$questionOption->answer=1;
								}else{
									
									$questionOption->answer=0;
								}
							$questionOption->save();
							}
							$i++;
							
							
						}
						
					}
				}


			sleep(1);
       	  }

		}
$rock->status=0;
$rock->save();
}


public function indiaBixCron(){
 		$rock= Rock::where(['scraper_id'=>2,'status'=>1])->first();



	   if(!$rock){
	   	 die("No active crons found");
	   }

        $category_id=$rock->category_id;
        $category=Category::find($category_id);
		if(!$category){
			abort(404);
		}

  	   $quizzes = range(1,$rock->pages);	
		foreach($quizzes as $sslug){

			  $quiz_id   =$category_id.'-indiabix-'.$sslug;
			  $alreadyScraped=Question::where(['scraper_id'=>$quiz_id])->count();
			  if(!$alreadyScraped){
       			$url=$rock->slug.'?page='.$sslug;

						  $crawler = \Goutte::request('GET', $url);

							$nodeValues[] = $crawler->filter('.bix-div-container')->each(function ($node){

							if($node->filter('.bix-td-qtxt')->count() && ! $node->filter('.bix-td-qtxt img')->count() ){
							$post['question']= $node->filter('.bix-td-qtxt')->html();
							
							$post['option']=$node->filter('.bix-tbl-options tr')->each(function($optionNode){	


								return preg_replace('/\s+/', ' ',str_replace(["\n","\t"],"",$optionNode->text()));		;
								
							});
							$post['answer']=$node->filter('.form-inputs .hidden input')->attr('value');
							
							
								return $post;
							}

							});


							$questions=[];
							foreach($nodeValues as $key=>$questionslist)
							{
								foreach($questionslist as $value){	
									if($value){
										$questions[]=$value;
										
										
										
									}
								}
							}


				foreach($questions as $data){

					$slug= strip_tags($data['question']);
				    $slug=Str::slug(substr($slug, 0,70));
					
					$question=Question::where(['slug'=> $slug])->first();
					if(!$question){
						
						$question=new Question;
						$question->name=trim($data['question']);
						$question->slug=$slug;
						$question->scraper_id=$quiz_id;
						$question->category_id=$category_id;
						$question->save();



						$i=1;
						foreach($data['option'] as $option){
							$option=preg_replace('/\s+/', ' ',str_replace(["A.","B.","C.","D."],"",$option));
							if(strlen($option)>0 && $option!="" &&  $option!=" "){
								$questionOption=new Option;
								$questionOption->question_id=$question->id;
								$questionOption->name=$option;
								if($i==$data['answer']){
									$questionOption->answer=1;
								}else{
									
									$questionOption->answer=0;
								}
							$questionOption->save();
							}
							$i++;
							
							
						}
						
					}
				}


			sleep(1);
       	  }

		}
$rock->status=0;
$rock->save();
}



public function examvedaCron(){
 		$rock= Rock::where(['scraper_id'=>2,'status'=>1])->first();



	   if(!$rock){
	   	 die("No active crons found");
	   }

        $category_id=$rock->category_id;
        $category=Category::find($category_id);
		if(!$category){
			abort(404);
		}

  	   $quizzes = range(1,$rock->pages);	
		foreach($quizzes as $sslug){

			  $quiz_id   =$category_id.'-examveda-'.$sslug;
			  $alreadyScraped=Question::where(['scraper_id'=>$quiz_id])->count();
			  if(!$alreadyScraped){
       			$url=$rock->slug.'?page='.$sslug;

						  $crawler = \Goutte::request('GET', $url);

							$nodeValues[] = $crawler->filter('.single-question')->each(function ($node){

							if($node->filter('.question-main')->count()){
							$post['question']= $node->filter('.question-main')->text();
							
							$post['option']=$node->filter('.form-inputs p')->each(function($optionNode){	


								return preg_replace('/\s+/', ' ',str_replace(["\n","\t"],"",$optionNode->text()));		;
								
							});
							$post['answer']=$node->filter('.form-inputs .hidden input')->attr('value');
							
							
								return $post;
							}

							});


							$questions=[];
							foreach($nodeValues as $key=>$questionslist)
							{
								foreach($questionslist as $value){	
									if($value){
										$questions[]=$value;
										
										
										
									}
								}
							}


				foreach($questions as $data){

					$slug= strip_tags($data['question']);
				    $slug=Str::slug(substr($slug, 0,70));
					
					$question=Question::where(['slug'=> $slug])->first();
					if(!$question){
						
						$question=new Question;
						$question->name=trim($data['question']);
						$question->slug=$slug;
						$question->scraper_id=$quiz_id;
						$question->category_id=$category_id;
						$question->save();



						$i=1;
						foreach($data['option'] as $option){
							$option=preg_replace('/\s+/', ' ',str_replace(["A.","B.","C.","D."],"",$option));
							if(strlen($option)>0 && $option!="" &&  $option!=" "){
								$questionOption=new Option;
								$questionOption->question_id=$question->id;
								$questionOption->name=$option;
								if($i==$data['answer']){
									$questionOption->answer=1;
								}else{
									
									$questionOption->answer=0;
								}
							$questionOption->save();
							}
							$i++;
							
							
						}
						
					}
				}


			sleep(1);
       	  }

		}
$rock->status=0;
$rock->save();
}


public function quizzesCron(){

		//dd($request->all());
	   $rock= Rock::where(['scraper_id'=>1,'status'=>1])->first();

	   if(!$rock){
	   	 die("No active crons found");
	   }
        $quizzes= explode(",",$rock->pages);
        if(!count($quizzes)){
				die("No pages to scrap");
        }

        $category_id=$rock->category_id;
        $category=Category::find($category_id);
		if(!$category){
			abort(404);
		}
        foreach( $quizzes as $sslug){
				$quiz_id   =$sslug;
		      $count=0;


       $alreadyScraped=Question::where(['scraper_id'=>$quiz_id])->count();


       if(!$alreadyScraped){
       			$url="https://quizizz.com/api/extSubs6/quiz/".$quiz_id;
		$json_data=file_get_contents($url);
		$quizObj=json_decode($json_data);
		//dd($quizObj);

		$questions=$quizObj->data->quiz->info->questions;
		$grades=$quizObj->data->quiz->info->grade;

		foreach($questions as $question){

				//dd($question);

			
				$name=strip_tags(trim($question->structure->query->text));



				$slug= strip_tags($name);
				$slug=Str::slug(substr($slug, 0,70));

				$image_path="";
				if(count($question->structure->query->media)){
					$media=$question->structure->query->media[0];
					if($media->type=='image'){



					$data=file_get_contents($media->url);


					
					$path = "questions/";
					$year_folder = $path . date("Y");
					$month_folder = $year_folder . '/' . date("m");

					$day_folder = $year_folder . '/' . date("m"). '/' .date("d");

					!file_exists($year_folder) && mkdir($year_folder , 0777);
					!file_exists($month_folder) && mkdir($month_folder, 0777);
					!file_exists($day_folder) && mkdir($day_folder, 0777);

					$image_path=$day_folder.'/'.Str::slug(substr($slug, 0,10)).time().'.jpg';

					file_put_contents($image_path, $data);
							

					
					}
				}

				$options=$question->structure->options;
				$answer=$question->structure->answer;
				$question=Question::where(['slug'=>$slug])->first();
				if(!$question){

						$question=new Question;
						$question->name=$name;
						$question->scraper_id=$quiz_id;
						$question->image=$image_path;
						$question->slug=$slug;
						$question->category_id=$category_id;
						$question->save();

						$count++;
						
						foreach($options as $key=> $opt){
							$option= new Option;
							$option->question_id=$question->id;
							$option->name=trim($opt->text);

					$image_path="";
				if(count($opt->media)){
					$media=$opt->media[0];
					if($media->type=='image'){



					$data=file_get_contents($media->url);


					
					$path = "questions/";
					$name=trim($option->name);
					$year_folder = $path . date("Y");
					$month_folder = $year_folder . '/' . date("m");

					$day_folder = $year_folder . '/' . date("m"). '/' .date("d");

					!file_exists($year_folder) && mkdir($year_folder , 0777);
					!file_exists($month_folder) && mkdir($month_folder, 0777);
					!file_exists($day_folder) && mkdir($day_folder, 0777);

					$image_path=$day_folder.'/'.Str::slug(substr($name, 0,10)).time().'.jpg';

					file_put_contents($image_path, $data);
							

					
					}
				}

							$option->image=$image_path;

							if($key==$answer)
							 $option->answer=1;
							else
							 $option->answer=0;
							$option->save();
					
						}

						foreach($grades as $gr){

							$grade=	Grade::find($gr);
							if($grade){
								$grade_question=new GradeQuestion;
								$grade_question->grade_id=$grade->id;
								$grade_question->question_id=$question->id;
								$grade_question->save();

							}

						}


				}
		

			

		}
	sleep(1);
       }


		

	

		}
$rock->status=0;
$rock->save();

}



public function quizzes(Request $request){

		//dd($request->all());
	

		$category_id=$request->category_id;

		$quiz_id   =$request->slug;
		$count=0;


		$category=Category::find($category_id);
		if(!$category){
			abort(404);
		}

//https://quizizz.com/admin/search/accounting // serach url 
		//https://quizizz.com/api/extSubs6/quiz/5846be8d29d4d2501c9938bb
		$url="https://quizizz.com/api/extSubs6/quiz/".$quiz_id;
		$json_data=file_get_contents($url);
		$quizObj=json_decode($json_data);
		//dd($quizObj);

		$questions=$quizObj->data->quiz->info->questions;
		$grades=$quizObj->data->quiz->info->grade;

		foreach($questions as $question){

				//dd($question);

			
				$name=strip_tags(trim($question->structure->query->text));



				$slug= strip_tags($name);
				$slug=Str::slug(substr($slug, 0,70));

				$image_path="";
				if(count($question->structure->query->media)){
					$media=$question->structure->query->media[0];
					if($media->type=='image'){



					$data=file_get_contents($media->url);


					
					$path = "questions/";
					$year_folder = $path . date("Y");
					$month_folder = $year_folder . '/' . date("m");

					$day_folder = $year_folder . '/' . date("m"). '/' .date("d");

					!file_exists($year_folder) && mkdir($year_folder , 0777);
					!file_exists($month_folder) && mkdir($month_folder, 0777);
					!file_exists($day_folder) && mkdir($day_folder, 0777);

					$image_path=$day_folder.'/'.Str::slug(substr($slug, 0,10)).time().'.jpg';

					file_put_contents($image_path, $data);
							

					
					}
				}

				$options=$question->structure->options;
				$answer=$question->structure->answer;
				$question=Question::where(['slug'=>$slug])->first();
				if(!$question){

						$question=new Question;
						$question->name=$name;
						$question->image=$image_path;
						$question->slug=$slug;
						$question->category_id=$category_id;
						$question->save();

						$count++;
						
						foreach($options as $key=> $opt){
							$option= new Option;
							$option->question_id=$question->id;
							$option->name=trim($opt->text);

					$image_path="";
				if(count($opt->media)){
					$media=$opt->media[0];
					if($media->type=='image'){



					$data=file_get_contents($media->url);


					
					$path = "questions/";
					$name=trim($option->name);
					$year_folder = $path . date("Y");
					$month_folder = $year_folder . '/' . date("m");

					$day_folder = $year_folder . '/' . date("m"). '/' .date("d");

					!file_exists($year_folder) && mkdir($year_folder , 0777);
					!file_exists($month_folder) && mkdir($month_folder, 0777);
					!file_exists($day_folder) && mkdir($day_folder, 0777);

					$image_path=$day_folder.'/'.Str::slug(substr($name, 0,10)).time().'.jpg';

					file_put_contents($image_path, $data);
							

					
					}
				}

$option->image=$image_path;

							if($key==$answer)
							 $option->answer=1;
							else
							 $option->answer=0;
							$option->save();
					
						}

						foreach($grades as $gr){

							$grade=	Grade::find($gr);
							if($grade){
								$grade_question=new GradeQuestion;
								$grade_question->grade_id=$grade->id;
								$grade_question->question_id=$question->id;
								$grade_question->save();

							}

						}


				}
		

			

		}






}

}

