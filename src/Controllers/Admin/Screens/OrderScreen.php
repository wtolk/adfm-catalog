<?php


namespace App\Http\Controllers\Admin\Screens;


use App\Helpers\Dev;
use App\Models\Adfm\Catalog\Order;
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
            'orders' => Order::paginate(50)
            // filter(request()->input('filter'))->
        ]);
        $screen->form->title = 'Заказы';
        $screen->form->addField(
            TableField::make('client_name', 'Имя покупателя')
                ->link(function ($model) {
                    echo Link::make($model->client_name)->route('adfm.orders.show', ['id' => $model->id])
                        ->render();
                })
        );
        $screen->form->addField(TableField::make('phone', 'Номер покупателя'));
        $screen->form->addField(TableField::make('cart.summ', 'Сумма заказа'));
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
            Input::make('filter.client_name:like')->title('Имф клиента')->setFilter(),
        ];
    }

    public static function getFields() {
        return [
            Column::make([
                Text::make('order.client_name')->title('Имя покупателя'),
                Text::make('order.phone')->title('Номер покупателя'),
                Text::make('order.address')->title('Адрес доставки'),
                Text::make('order.note')->title('Примечание'),
                Text::make('order.created_at')->title('Дата заказа'),
                Table::make('order.cart.products')->title('Список товаров')->setFields(
                    ['title' => 'Название','count' => 'Количество', 'price' => 'Цена' ]
                ),
                Text::make('order.cart.summ')->title('Сумма заказа'),
            ])->class('col col-md-12')
        ];
    }
}
