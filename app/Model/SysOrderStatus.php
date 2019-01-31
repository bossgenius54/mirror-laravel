<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class SysOrderStatus extends Model{
    protected $table = 'sys_order_status';
    protected $fillable = ['name', 'bootstrap_class'];
    
    CONST CREATED = 1; // Создан
    CONST NEED_APPROVE = 2; // Список сформирован/На утверждении
    CONST APPROVED = 3; // Заказ одобрен
    CONST WAIT_PAY = 4; // Ожидание оплаты
    CONST MAKING = 5; // Изготовление заказа
    CONST READY_TO_SEND = 6; // Готов к отправки
    CONST SENDED = 7; // Отправлено
    CONST CLOSED = 8; // Получено/Заверешно
    CONST CANCELED = 9; // Отменено/Отменено
    CONST RETURNED = 10; // Возврат

    static function getCanManagerUpdate(){
        return [
            static::CREATED, static::NEED_APPROVE, static::APPROVED, static::WAIT_PAY, static::MAKING, static::READY_TO_SEND, static::SENDED
        ];
    }

    static function getCanManagerChangeStatus(){
        return ;
    }
    
}
