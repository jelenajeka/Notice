<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Michelf\Markdown;
use Illuminate\Support\Facades\File;
use App\NoticesType;
use App\UsersEdited;
use App\Attachments;
use App\Images;
use App\Notices;


class NoticeController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function viewNotices()
  {
    $notices = Notices::all();
    return view('table', ['notices' => $notices])->render();
  }

  public function types()
  {
    $types = NoticesType::all();
    return view('types', ['types' => $types]);
  }

  public function viewType(Request $request, $id)
  {
    $type = NoticesType::findOrFail($id);
    return view('type',
      [
        'type' => $type,
        'action_url'=>"/types/".$id,
        'method'=>"post",
        'action' => "put"
      ]);
  }

  public function viewAddType()
  {
    $type= (object) [
      'type_name' => '',
    ];
    $type_name = '';
    return view('type',
      [
        'type' => $type,
        'type_name' => $type_name,
        'action_url'=>"/types/create",
        'method' => "post",
        'action' => "post"
      ]);
  }

  public function addType(Request $request)
  {
      $request->validate([
              'type_name'=>'required',
          ]);
      $type = NoticesType::create($request->all());
      return view('success');
  }

  public function editType(Request $request, $id)
  {
    $type = NoticesType::findOrFail($id);
      $request->validate([
        'type_name'=>'required',

      ]);

      $type->type_name = $request->input('type_name');
      $type->save();
      return view('success');

  }

  public function deleteType(Request $request)
  {
   $notices = Notices::all();
   $t = NoticesType::find($request->input('id'));

   $del = 0;
   foreach($notices as $n)
   {
     if($n->type == $t->id)
     {
       $del = 1;
     }
   }
   if($del == 0){
     $t->delete();
     echo 'deleted';
   }elseif( $del == 1){
     echo 'not';
   }
  }

  public function viewAddNotice(Request $request)
  {
     $notice = (object) [
       'type' =>'',
       'title' => '',
       'text' => '',
     ];
    $notice_formatted ='';
    $img = '';
    $attach = '';
    $editer = '';
    $types = NoticesType::all();

    return view('notice',
     [
       'notice' => $notice,
       'types'=> $types,
       'img' => $img,
       'attach' => $attach,
       'notice_formatted' => $notice_formatted,
       'editer' => $editer,
       'action_url' => "/notices/create",
       'method' => "post",
       'action' => "post"
     ]);
  }

  public function addNotice(Request $request)
  {

    $request->validate([
            'type'=>'required',
            'title'=>'required',
        ]);

    $notice_data = array(
      'title' => $request->input('title'),
      'text' => $request->input('text'),
      'type' => $request->input('type'),
      'user_id' => Auth::user()->id,
      'img' => $request->input('img'),
      'attach' => $request->input('attach')
    );

    $notes = Notices::create($notice_data);
    return view('success');
  }

  public function transformText($text)
  {
    $html = Markdown::defaultTransform($text);
    return $html;
  }

  public function viewEditNotice(Request $request, $id)
  {
    $types = NoticesType::all();
    $notice = Notices::with('noticeby')->findOrFail($id);
    $notice_formatted = $this->transformText($notice->text);
    $notices = Notices::with('noticeby')->get();
    $img = $notice->img;
    $attach = $notice->attach;
    $editer = UsersEdited::with('editedby')->where('notice_id',$notice->id)->get();

    return view('notice',
      [
        'types' => $types,
        'notice' => $notice,
        'notice_formatted' => $notice_formatted,
        'editer' => $editer,
        'img'=>$img,
        'attach'=>$attach,
        'action_url'=>"/notices/".$id,
        'method'=>"post",
        'action' => "put"
      ]);
  }

  public function editNotice(Request $request, $id)
  {
    $notice = Notices::with('noticeby')->findOrFail($id);
      $request->validate([
          'type'=>'required',
          'title'=>'required',
      ]);

      $notice->title = $request->input('title');
      $notice->text = $request->input('text');
      $notice->type = $request->input('type');
      $notice->img = $request->input('img');
      $notice->attach = $request->input('attach');
      $notice->save();
      if( UsersEdited::create([
              'notice_id' => $notice->id,
              'user_id' =>  Auth::user()->id,
            ]))
      {
        return view('success')->with('success',"Notice is edited!");
      }
      else{
        return view('success')->with('success',"Notice don't edited!");
      }
  }

  public function textFormated(Request $request)
  {

    if($request->isMethod('post'))
    {
      $text = $request->input('text');
      $html = Markdown::defaultTransform($text);
      return $html;
    }
  }

  public function searchNotice(Request $request)
  {
    $search_notice = $request->query('search_notice');
    $notices = Notices::with('noticeby')->where('title', 'Like', '%' .$search_notice. '%')->get();
    return view('table', ['notices' => $notices ])->render();
  }
  public function noticesGroup(Request $request)
  {
      $group_id = $request->input('group_id');
      $notices = Notices::where('type',$group_id)->get();
      return view('table', ['notices' => $notices])->render();
  }

  public function viewNotice(Request $request, $id)
  {
      $notice = Notices::with(['noticeby','noticetype'])->findOrFail($id);
      $notice_formatted = $this->transformText($notice->text);
      $editer = UsersEdited::with('editedby')->where('notice_id',$notice->id)->get();
      return view('viewNotice',
        [
          'notice_formatted' => $notice_formatted,
          'notice' => $notice,
          'editer' => $editer
        ]);
  }

  public function uploadFormImg(Request $request)
  {
     $images = array();
     if($request->ajax())
     {
       if($request->hasFile('img_input'))
       {
         $image = $request->file('img_input');
         $img_name = rand() . '.' . $image->getClientOriginalExtension();

         $path = public_path().'/images';
         if (!is_dir($path)) {
          mkdir($path);
         }

         $destination = public_path('/images');
         $image->move($destination,$img_name);
         $images= Images::create(['img' => $img_name]);
         return json_encode($images);
        }
      }
    }

  public function notSaveImage(Request $request)
  {
    if($request->isMethod('post'))
    {
       $upload_local = $request->input('upload_local');
       $img = Images::where('img', $upload_local)->delete();
       $image_path =  public_path().'//images/'.$upload_local;
       if(file_exists($image_path)) {
        File::delete($image_path);
        }
        return json_encode($img);
    }
  }

  public function uploadFormFile(Request $request)
  {
    if($request->ajax())
    {
      if($request->hasFile('file'))
      {
        $file = $request->file('file');
        $file_name = rand() . '.' . $file->getClientOriginalExtension();

        $path = public_path().'/files';
        if (!is_dir($path)) {
         mkdir($path);
        }

        $destination = public_path('/files');
        $file->move($destination,$file_name);
        $files= Attachments::create(['file' => $file_name]);
        return json_encode($files);
       }
     }
   }

  public function notSaveFile(Request $request)
  {
    if($request->isMethod('post'))
    {
       $upload_local_file = $request->input('upload_local_file');
       $file = Attachments::where('file', $upload_local_file)->delete();
       $file_path=  public_path().'//files/'.$upload_local_file;
       if(file_exists($file_path)) {
        File::delete($file_path);
      }
     return 'delete';
    }
  }

  public function deleteNotice(Request $request)
  {
    $notice = Notices::find($request->input('id'));
    if(is_object($notice) && !empty($notice))
    {
      $img = $notice->img;
      $str_arr = preg_split ("/\,/", $img);
      foreach($str_arr as $s)
      {
          $im = Images::find($s);
          if(is_object($im) && !empty($im))
          {
            $img_name = $im->img;
            $image_path = public_path().'//images/'.$img_name;
            if(file_exists($image_path)) {
              File::delete($image_path);
            }
            $im->delete();
          }

      }
        $attach = Notices::find($request->input('id'));
        $f = $attach->attach;
        $str_f = preg_split ("/\,/", $f);
        foreach($str_f as $s)
        {
            $af = Attachments::find($s);
            if(is_object($af) && !empty($af))
            {
              $file_name = $af->file;
              $file_path=  public_path().'//files/'.$file_name;
              if(file_exists($file_path)) {
                File::delete($file_path);
              }
              $af->delete();
            }
        }
        $user_edit = UsersEdited::where('notice_id', $request->input('id'))->delete();
        if($notice->delete())
        {
          return 'deleted';
        }
      }
  }
}
