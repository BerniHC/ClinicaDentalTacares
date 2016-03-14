<?php
class ResetToken extends Eloquent {
    
    protected $table = 'reset_tokens';
    
    public $timestamps = true;
    protected $softDelete = true;
}