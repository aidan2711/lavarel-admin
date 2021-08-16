<?php

namespace App\Admin\Controllers;

use App\Models\Event;
use App\Models\MatchTypes;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class EventsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Event';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Event());

        $grid->column('id', 'ID')->link(function ($event){
            return "/admin/events/$event->id";
        });
        $grid->column('match_id', __('Match/Event ID'))->expand(function ($model) {
            $event = $model->where('id','=', $this->id)->get()->first()->only(['league_name','home_team', 'visiting_team', "time"]);
            return new Table(['Giải Đấu','Đội Nhà', 'Đội Khách', 'Thời gian'],  [$event]);
        });
        $grid->column('league_id', __('League ID'));
        $grid->column('league_name', __('Giải Đấu'));
        $grid->column('home_team', __('Đội Nhà'));
        $grid->column('visiting_team', __('Đội Khách'));
        $grid->column('time', __('Thông tin'));
        $grid->column('match_type_id', __('Loại'))->display(function ($id) {
            $matchType = MatchTypes::findOrFail($id);

            return  $matchType->slug ;
        });
        $grid->column('position', __('Vị trí'));
        $grid->column('status', __('Trạng thái'))->display(function ($status) {
            return $status == 1 ?  "<span class='label label-success'>PUBLISH</span>" : "<span class='label label-danger'>PRIVATE</span>";
        });

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
        $show = new Show(Event::findOrFail($id));

        $show->field('match_id', __('Match ID'));
        $show->field('league_id', __('League ID'));
        $show->field('league_name', __('Giải Đấu'));
        $show->field('home_team', __('Đội Nhà'));
        $show->field('home_flag', __('Cờ Đội Nhà'));
        $show->field('visiting_team', __('Đội Khách'));
        $show->field('visiting_flag', __('Cờ Đội Khách'));
        $show->field('time', __('Thời gian'));
        $show->field('position', __('Vị trí xuất hiện'));
        $show->field('status', __('Trạng thái'));
        $show->field('url', __('Link bài viết'));
        // $show->field('created_at', __('Created at'));
        // $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Event());
        $form->column(6, function ($form) {
            $form->text('home_team', __('Tên Đội Nhà'));
            $form->image('home_flag', __('Cờ: (jpg, jpeg, png)'));
            $form->text('match_id', __('Match ID'));
            $form->text('league_id', __('League ID'));
            $form->text('league_name', __('Giải Đấu'));
            $form->text('league_display', __('Giải Đấu Hiển Thị'));
            $form->text('time', __('Thời gian'));
            $form->number('position', __('Vị trí xuất hiện'));

            $status = [
               1 => 'PUBLISH',
               2 => 'PRIVATE',
            ];

            $form->select('status', __('Trạng thái'))->options($status);

            $matchType = MatchTypes::all();
            $types = array();
            foreach ($matchType as $item) {
                $types += array($item->id => "{$item->name}");
            }
            
            $form->select('match_type_id', __('Loại'))->options($types);

            $form->text('url', __('Link bài viết'));
        });

        $form->column(6, function ($form) {
            $form->text('visiting_team', __('Tên Đội Khách'));
            $form->image('visiting_flag', __('Cờ: (jpg, jpeg, png)'));
        });

        return $form;
    }
}