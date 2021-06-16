<?php


namespace App\Http\Controllers\Admin\Screens;


use App\Helpers\Dev;
use App\Models\Adfm\Order;
use Whoops\Exception\ErrorException;
use Wtolk\Crud\Form\Checkbox;
use Wtolk\Crud\Form\Column;
use Wtolk\Crud\Form\DataFields\Text;
use Wtolk\Crud\Form\DataFields\Table;
use Wtolk\Crud\Form\DateTime;
use Wtolk\Crud\Form\File;
use Wtolk\Crud\Form\Link;
use Wtolk\Crud\Form\MultiFile;
use Wtolk\Crud\Form\Summernote;
use Wtolk\Crud\Form\TableField;
use Wtolk\Crud\FormPresenter;
use Wtolk\Crud\Form\Input;
use Wtolk\Crud\Form\Button;

class OrderScreen
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
            'orders' => Order::filter(request()->input('filter'))->paginate(50)
        ]);
        $screen->form->title = 'Заказы';
        $screen->form->addField(
            TableField::make('name', 'Имя покупателя')
                ->link(function ($model) {
                    echo Link::make($model->name)->route('adfm.orders.show', ['id' => $model->id])
                        ->render();
                })
        );
        $screen->form->addField(TableField::make('phone', 'Номер покупателя'));
        $screen->form->addField(TableField::make('summ', 'Сумма заказа'));
        $screen->form->addField(TableField::make('created_at', 'Дата создания'));
        $screen->form->filters(self::getFilters());
        $screen->form->build();
        $screen->form->render();
    }

    public static function show()
    {
        $screen = new self();
        $screen->form->isModelExists = true;
        $screen->form->template('form-edit')->source([
                'order' => Order::findOrFail($screen->request->route('id'))
        ]);
        $screen->form->title = 'Просмотр заказа № '.$screen->request->route('id');
        $screen->form->columns = self::getFields();
        $screen->form->buttons([
            Link::make('Вернуться назад')->route('adfm.orders.index')
        ]);

        $screen->form->build();
        $screen->form->render();
    }

    public static function getFilters() {
        return [
            Input::make('filter.title:like')->title('Заголовок страницы')->setFilter(),
            Input::make('filter.content:like')->title('Текст страницы')->setFilter(),
        ];
    }

    public static function getFields() {
        return [
            Column::make([
                Text::make('order.name')->title('Имя покупателя'),
                Text::make('order.phone')->title('Номер покупателя'),
                Text::make('order.meta.adress')->title('Адрес доставки'),
                Text::make('order.created_at')->title('Дата заказа'),
                Table::make('order.products')->title('Список товаров')->setFields(
                    ['title' => 'Название','count' => 'Количество', 'price' => 'Цена' ]
                ),
                Text::make('order.summ')->title('Сумма заказа'),
            ])->class('col col-md-12')
        ];
    }
}
