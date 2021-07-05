<?php

namespace App\Http\Controllers\Admin\Screens;

use App\Helpers\Adfm\ImageCache;
use App\Models\Adfm\Catalog\Category;
use App\Helpers\Dev;
use Spatie\Permission\Models\Role;
use Wtolk\Crud\Form\Column;
use Wtolk\Crud\Form\File;
use Wtolk\Crud\Form\MultiFile;
use Wtolk\Crud\Form\Relation;
use Wtolk\Crud\Form\Select;
use Wtolk\Crud\Form\Summernote;
use Wtolk\Crud\Form\TinyMCE;
use Wtolk\Crud\FormPresenter;
use App\Models\Adfm\Catalog\Product;
use Wtolk\Crud\Form\Input;
use Wtolk\Crud\Form\Checkbox;
use Wtolk\Crud\Form\TableField;
use Wtolk\Crud\Form\Link;
use Wtolk\Crud\Form\Button;


class ProductScreen
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
            'products' => Product::filter(request()->input('filter'))->paginate(50)
        ]);
        $screen->form->title = 'Товары';


        $screen->form->filters(self::getFilters());
        $screen->form->addField(
            TableField::make('title', 'Изображение')
                ->link(function ($model) {
                    if(count($model->files) > 0){
                        echo Link::make(ImageCache::get($model->files[0], ['w' => 50, 'h' => 50, 'fit' => 'crop']))->route('adfm.products.edit', ['id' => $model->id])->render();
                    }
                })
        );
        $screen->form->addField(
            TableField::make('title', 'Название')
                ->link(function ($model) {
                    echo Link::make($model->title)->route('adfm.products.edit', ['id' => $model->id])->render();
            })
        );
        $screen->form->addField(TableField::make('price', 'Цена'));
        $screen->form->addField(TableField::make('created_at', 'Дата создания'));
        $screen->form->addField(
            TableField::make('delete', 'Операции')
                ->link(function ($model) {
                    echo Link::make('Удалить')->route('adfm.products.destroy', ['id' => $model->id])->render();
            })
        );
        $screen->form->buttons([
            Link::make('Добавить')->class('button')->icon('note')->route('adfm.products.create')
        ]);
        $screen->form->build();
        $screen->form->render();
    }

    public static function create()
    {
        $screen = new self();
        $screen->form->isModelExists = false;
        $screen->form->template('form-edit')->source([
            'product' => new Product()
        ]);
        $screen->form->title = 'Создание товара';
        $screen->form->route = route('adfm.products.store');
        $screen->form->columns = self::getFields();
        $screen->form->buttons([
            Button::make('Сохранить')->icon('save')->route('adfm.products.update')->submit(),
            Button::make('Удалить')->icon('trash')->route('adfm.products.destroy')->canSee($screen->form->isModelExists)
        ]);
        $screen->form->build();
        $screen->form->render();
    }

    public static function edit()
    {
        $screen = new self();
        $screen->form->isModelExists = true;
        $screen->form->template('form-edit')->source([
            'product' => Product::findOrFail($screen->request->route('id'))
        ]);
        $screen->form->title = 'Редактирование товара';
        $screen->form->route = route('adfm.products.update', $screen->form->source['product']->id);
        $screen->form->columns = self::getFields();
        $screen->form->buttons([
            Button::make('Сохранить')->icon('save')->route('adfm.products.update')->submit(),
            Button::make('Удалить')->icon('trash')->route('adfm.products.destroy')->canSee($screen->form->isModelExists)
        ]);
        $screen->form->build();
        $screen->form->render();
    }

    public static function getFields() {
        $product = Product::find(request()->route('id'));
        $categories = ($product && $product->categories) ? $product->categories->pluck('title', 'id')->toArray() : null;
        return [
            Column::make([
                Input::make('product.title')->title('Название')->required(),
                Input::make('product.price')->required()->title('Цена'),
                Input::make('product.article')->title('Артикул')->placeholder('6230i'),
                TinyMCE::make('product.content')->title('Описание товара'),
                MultiFile::make('product.files')->title('картинки')->preview()
            ]),
            Column::make([
                Input::make('product.slug')->title('Вид в адресной строке'),
                Relation::make('product.categories')->options(
                    Category::all()->pluck('title', 'id')->toArray()
                )->title('Категории товара')->multiple()->defaultValue($categories),
                Input::make('product.meta.title')->title('TITLE (мета-тег)'),
                Input::make('product.meta.description')->title('Description (мета-тег)'),
            ])->class('col col-md-4')
        ];
    }


    public static function getFilters() {
        return [
            Input::make('filter.title:like')->title('Заголовок товара')->setFilter(),
            Input::make('filter.content:like')->title('Текст товара')->setFilter(),
        ];
    }

}
