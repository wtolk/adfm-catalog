<?php

namespace App\Http\Controllers\Admin\Screens;

use App\Helpers\Dev;
use Wtolk\Crud\Form\Column;
use Wtolk\Crud\Form\File;
use Wtolk\Crud\Form\Relation;
use Wtolk\Crud\Form\Summernote;
use Wtolk\Crud\Form\TinyMCE;
use Wtolk\Crud\FormPresenter;
use App\Models\Adfm\Catalog\Category;
use Wtolk\Crud\Form\Input;
use Wtolk\Crud\Form\Checkbox;
use Wtolk\Crud\Form\TableField;
use Wtolk\Crud\Form\Link;
use Wtolk\Crud\Form\Button;


class CategoryScreen
{
    public $form;
    public $request;

    public function __construct()
    {
        $this->form = new FormPresenter();
        $this->request = request();

    }

    public static function index()
    {
        $screen = new self();
        $screen->form->template('table-list')->source([
            'categories' => Category::paginate(50)
        ]);
        $screen->form->title = 'Категории товаров';
        $screen->form->addField(
            TableField::make('title', 'Название')
                ->link(function ($model) {
                    echo Link::make($model->title)->route('adfm.categories.edit', ['id' => $model->id])->render();
            })
        );
        $screen->form->addField(TableField::make('created_at', 'Дата создания'));
        $screen->form->addField(
            TableField::make('delete', 'Операции')
                ->link(function ($model) {
                    echo Link::make('Удалить')->route('adfm.categories.destroy', ['id' => $model->id])->render();
            })
        );
        $screen->form->buttons([
            Link::make('Добавить')->class('button')->icon('note')->route('adfm.categories.create')
        ]);
        $screen->form->build();
        $screen->form->render();
    }

    public static function create()
    {
        $screen = new self();
        $screen->form->isModelExists = false;
        $screen->form->template('form-edit')->source([
            'category' => new Category()
        ]);
        $screen->form->title = 'Создание категории';
        $screen->form->route = route('adfm.categories.store');
        $screen->form->columns = self::getFields();
        $screen->form->buttons([
            Button::make('Сохранить')->icon('save')->route('adfm.categories.update')->submit(),
            Button::make('Удалить')->icon('trash')->route('adfm.categories.destroy')->canSee($screen->form->isModelExists)
        ]);
        $screen->form->build();
        $screen->form->render();
    }

    public static function edit()
    {
        $screen = new self();
        $screen->form->isModelExists = true;
        $screen->form->template('form-edit')->source([
            'category' => Category::findOrFail($screen->request->route('id'))
        ]);
        $screen->form->title = 'Редактирование категории';
        $screen->form->route = route('adfm.categories.update', $screen->form->source['category']->id);
        $screen->form->columns = self::getFields();
        $screen->form->buttons([
            Button::make('Сохранить')->icon('save')->route('adfm.categories.update')->submit(),
            Button::make('Удалить')->icon('trash')->route('adfm.categories.destroy')->canSee($screen->form->isModelExists)
        ]);
        $screen->form->build();
        $screen->form->render();
    }

    public static function getFields() {
        return [
            Column::make([
                Input::make('category.title')->title('Название категории'),
                Input::make('category.slug')->title('Вид в адресной строке'),
                Relation::make('category.parent_id')->title('Родительская категория')
                    ->options(Category::all()->pluck('title', 'id')->toArray())->empty('Нет', '0'),
                Summernote::make('category.description')->title('Описание категории'),
            ])
        ];
    }

}
