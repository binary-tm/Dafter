<?php

namespace App\Admin\Controllers;

use App\Helpers\Common;
use App\Models\User;
use App\Models\users;
use App\Models\users_notification;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;

class Users_NotificationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'users_notification';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        
        $grid = new Grid(new users_notification());
        $grid->column('id', __('Id'));
        $grid->column('name.name', __('Name'));
        $grid->column('user_id', __('user_id'));
        $grid->column('title', __('title'));
        $grid->column('content', __('content'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));


        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(users_notification::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new users_notification());

     
        $form->select('user_id', trans('user'))->options (function (){
            $ops = [0=>trans ('all')];
            foreach (users::all () as $user){
                $ops[$user->id] = $user->id.'--'.($user->nicename?:$user->name);
            }
            return $ops;
        });

        $form->text('title', __('title'));
        $form->text('content', __('content'));

        $form->saved(function (Form $form) {
            

       

            $formData = $form->model()->toArray();
            $title=$formData['title']??'';
            $body=$formData['content']??'';
            // $img='https://kita.rstar-soft.com/storage/images/kitaimg.jpg';
            $img='';
            
            // if ($formData['img'] !== null) {
            //     $img=$formData['img']??'';
            // }else{
            //     $img=null;
            // }
            $userid=$formData['user_id'];
            $icon = ''; // Specify the icon URL if needed

            $data = [
                'image' => $img // Specify the image URL
            ];
            $tokens ='';
            if ($userid == 0) {
                $tokens = DB::table('users')->pluck('notification_id')->all();
                foreach ($tokens as $token) {
                    Common::send_firebase_notification($token,$title,$body,$icon,$data);
                }

            }
            if(!$userid == 0 ){
                $token = DB::table('users')->where('id', $userid)->value('notification_id');
                Common::send_firebase_notification($token,$title,$body,$icon,$data);

            }
        });
        return $form;
    }
}
