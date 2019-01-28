<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class SysOrderStatus extends Model{
    protected $table = 'sys_order_status';
    protected $fillable = ['name'];
    
    CONST CREATED = 1; // Создан
    CONST FORMATION = 2; // Формирование заказа
    CONST DONE_FORMATION = 3; // Заказ сформирован
    CONST WAIT_PAY = 4; // Ожиадние оплаты
    CONST MAKING = 5; // Изготовление в процессе
    CONST DONE_MAKE = 6; // Изготовление заверщено
    CONST SENDED = 7; // Отправлено
    CONST RECIEVED = 8; // Получено
    CONST CLOSED = 9; // Завершено
    CONST CANCELED = 10; // Отменен
    CONST RETURNED = 11; // Возврат
}
