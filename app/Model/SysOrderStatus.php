<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class SysOrderStatus extends Model{
    protected $table = 'sys_order_status';
    protected $fillable = ['name'];
    
    CONST CREATED = 1; // Создан
    CONST FORMATION = 2; // Формирование заказа
    CONST WAIT_PAY = 3; // Ожиадние оплаты
    CONST MAKING = 4; // Изготовление в процессе
    CONST DONE_MAKE = 5; // Изготовление заверщено
    CONST SENDED = 6; // Отправлено
    CONST RECIEVED = 7; // Получено
    CONST CLOSED = 8; // Завершено
    CONST CANCELED = 9; // Отменен
    CONST RETURNED = 10; // Возврат
}
