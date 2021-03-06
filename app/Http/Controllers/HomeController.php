<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Category; // getting the data
use App\Events;
use App\SubCategory;
use App\groups_subs;
use App\Groups;
use App\events_subs;
use App\users_subs;
use App\events_reports;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /* home page*/
    public function welcome(){
        $categories = array(Category::all());
        // dd(gettype($categories));
        $subs = SubCategory::all();
        // dd($categories);
        $id = Auth::user()->id;
        $relatedEvents = Events::findInterestedCategory();
        $allevents = Events::all();
        // dd(gettype($allevents));
        // dd($allevents);
        // $relatedEvents = $relatedEvents->toArray();
        // $relatedEvents = $relatedEvents['data'];

        return view('welcome',['categories' =>$categories['0'],'event'=>$relatedEvents,'subs'=>$subs, 'events'=>$allevents]);
    }

    public function admin() {
        return view('admin.administration');
    }

    public function addParentName(Request $request) {

            $id =Category::all()->last();
            if($id==null) {
                $id = 1;
            }
            else {
                $id = $id->id + 1;
            }

            $name = $request->input('catname');
            $exist = Category::where('cat_name','=',$name)->first();
            if ( $exist==null ) {
                    $cate = new Category();
                    $cate->id = $id;
                    $cate->cat_name= $name;
                    $cate->save();

                    return redirect('/admin/preferences')->with('parentMessage','You added Parent Name to the database');
            }
            else {
                    return redirect('/admin/preferences')->with('parentErrorMessage','Failed to add record to Parent Category, similar record found in database!');
            }
    }

    public function addChildName(Request $request){

            $catid = $request->input('category');
            if($catid==null){
                 return redirect('/admin/preferences')->with('childErrorMessage','Category is not selected or No related category found in the database!! Add or select the CATEGORY FIRST!!');
            }

             $id = SubCategory::all()->last();
            if($id==null){
                $id = 1;
            }
            else{
                 $id = $id->id + 1;
            }

            $name = $request->input('childname');
            $exist = SubCategory::where('name','=',$name)->first();

            if($exist==null){
                 $cate = new SubCategory();
                $cate->id = $id;
                $cate->cate_id= $catid;
                $cate->name = $name;
                $cate->save();

                return redirect('/admin/preferences')->with('childMessage','You added Child Name to the database');
            }
            else{
                return redirect('/admin/preferences')->with('childErrorMessage','You failed to add Child Name to the database, It may be that you try to add same data to the database');
            }
    }

    public function deleteParentName(Request $request) {

            $id = $request->input('deleteCategory');
             $exist = SubCategory::where('cate_id','=',$id)->pluck('id')->toArray(); //check the sub category for the main category


            //because if delete parent , need to all other related table
            foreach($exist as $e) {
                $result = SubCategory::where('id','=',$e);
                $result->delete();
            }
            //delete user with subs
            foreach($exist as $e) {
                $result = users_subs::where('sub_id','=',$e);
                $result->delete();
            }
            //delete group subs
             foreach($exist as $e) {
                $result = groups_subs::where('sub_id','=',$e);
                $result->delete();
            }
            //delte relevant event subs
            foreach($exist as $e) {
                $result = events_subs::where('sub_id','=',$e);
                $result->delete();
            }
            Category::destroy($id);

            return redirect('/admin/preferences')->with('parentDeleteMessage','You deleted Parent Name from the database');
    }

    public function deleteChildName(Request $request) {

            $id = $request->input('deleteChild');
            SubCategory::destroy($id);
             $result = events_subs::where('sub_id','=',$id);
                $result->delete();
            $result = users_subs::where('sub_id','=',$id);
                $result->delete();
             $result = groups_subs::where('sub_id','=',$id);
                $result->delete();

            return redirect('/admin/preferences')->with('childDeleteMessage','You deleted Child Name from the database');

    }
    public function showGroups($groupname) {
       $output = Groups::getGroupsWithEachCategory($groupname);

        // dd($output);
        return view('grouplist',['items'=>$output , 'name'=>$groupname]);
    }

    public function reportedEvents() {
        $reports = DB::table('events_reports')
                      ->join('events', 'events_reports.event_id', '=', 'events.id')
                      ->select('events_reports.*', 'events.title')
                      ->get();

        return view('adminReports', ['reports' => $reports] );
    }

    public function removeEvent($id) {

      DB::table('events_users')
          ->where('event_id','=',$id)
          ->delete();

      DB::table('events_subs')
          ->where('event_id','=',$id)
          ->delete();

      DB::table('events_reports')
          ->where('event_id','=',$id)
          ->delete();

      DB::table('events')
        ->where('id', '=', $id)
        ->delete();

        return redirect(route('adminReports'));
    }

    public function ignoreReport($id) {
      DB::table('events_reports')
          ->where('events_reports.id','=',$id)
          ->delete();

      return redirect(route('adminReports'));
    }

    public function showPreferences() {
        $parent = array(Category::all());
        $child = SubCategory::all();

        return view('dashboard', ['parents' => $parent['0'], 'children' => $child] );
    }

    public function pageNotFound(){
      return view('errors.503');
    }

}
