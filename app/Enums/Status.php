<?php 

namespace App\Enums;

class  Status
{
    const ACTIVE = 'active';
    const INACTIVE = 'inactive';
    const PENDING = 'pending';
    const APPROVED = 'approved';
    const REJECTED = 'rejected';
    const DELETED = 'deleted';
    const BLOCKED = 'blocked';
    const UNBLOCKED = 'unblocked';
    const EXPIRED = 'expired';
    const COMPLETED = 'completed';
    const CANCELLED = 'cancelled';
    const FAILED = 'failed';
    const SUCCESS = 'success';
    const PENDING_PAYMENT = 'pending_payment';
    const PAID = 'paid';
    const UNPAID = 'unpaid';

    public static function getStatusValues()
    {
        return [
            self::ACTIVE,
            self::INACTIVE,
            self::PENDING,
            self::APPROVED,
            self::REJECTED,
            self::DELETED,
            self::BLOCKED,
            self::UNBLOCKED,
            self::EXPIRED,
            self::COMPLETED,
            self::CANCELLED,
            self::FAILED,
            self::SUCCESS,
            self::PENDING_PAYMENT,
            self::PAID,
            self::UNPAID,
        ];
    }
}