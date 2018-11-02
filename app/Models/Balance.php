<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;

class Balance extends Model
{
    /****************************************************************
        * CLASSE RESPONSAVEL POR CRIAR|INSERIR|ATUALIZAR OS REGISTROS 
        * DE ENTRADA E SAIDA DE DINHEIRO
    ****************************************************************/
    public $timestamps = false;

    public function deposit(float $value) : Array
    {
        /**************************************************
        * METODO PARA RECARGA
        **************************************************/
    	DB::beginTransaction();

    	$totalBefore = $this->amount ? $this->amount : 0;
    	$this->amount+= number_format($value, 2, '.', '');
    	$deposit = $this->save();

    	$historic = auth()->user()->historics()->create([
    		'type'         => 'I', 
    		'amount'       => $value, 
    		'total_before' => $totalBefore, 
    		'total_after'  => $this->amount, 
    		'date'         => date('Y-m-d')
    	]);

        /**************************************************
        * EXECUTA O COMMIT OU ROLLBACK
        **************************************************/

    	if ($deposit && $historic) {
    		DB::commit();
    		return [
    			'success' => true,
    			'message' => 'Recarga realizada com sucesso!'
    		];	
    	}else{
    		DB::rollback();
    		return [
    			'success' => false,
    			'message' => 'Recarga não foi realizada.'
    		];
    	}
	
    }

    public function withdraw(float $value) : Array
    {

        /**************************************************
        * METODO PARA SAQUE
        **************************************************/

    	if ($this->amount < $value) {
    		return [
    			'success' => false,
    			'message' => 'Saldo insuficiente para essa operação.'
    		];
    	}

    	DB::beginTransaction();

    	$totalBefore = $this->amount ? $this->amount : 0;
    	$this->amount -= number_format($value, 2, '.', '');
    	$withdraw = $this->save();

    	$historic = auth()->user()->historics()->create([
    		'type'         => 'O', 
    		'amount'       => $value, 
    		'total_before' => $totalBefore, 
    		'total_after'  => $this->amount, 
    		'date'         => date('Y-m-d')
    	]);

        /**************************************************
        * EXECUTA O COMMIT OU ROLLBACK
        **************************************************/

    	if ($withdraw && $historic) {
    		DB::commit();
    		return [
    			'success' => true,
    			'message' => 'Retirada realizada com sucesso!'
    		];	
    	}else{
    		DB::rollback();
    		return [
    			'success' => false,
    			'message' => 'Retirada não foi realizada.'
    		];
    	}
    }

    public function transfer(float $value, User $sender) : Array
    {
        /**************************************************
        * METODO PARA TRANSFERENCIA
        **************************************************/

        if ($this->amount < $value) {
            return [
                'success' => false,
                'message' => 'Saldo insuficiente para essa operação.'
            ];
        }

        DB::beginTransaction();

        /**************************************************
        * ATUALIZA O SALDO DE QUEM ENVIA
        **************************************************/

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount -= number_format($value, 2, '.', '');
        $transfer = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'                => 'T', 
            'amount'              => $value, 
            'total_before'        => $totalBefore, 
            'total_after'         => $this->amount, 
            'date'                => date('Y-m-d'),
            'user_id_transaction' => $sender->id,
        ]);

       /**************************************************
        * ATUALIZA O SALDO DE QUEM RECEBE
        **************************************************/

        $senderBalance = $sender->balance()->firstOrCreate([]);

        $senderTotalBefore = $senderBalance->amount ? $senderBalance->amount : 0;
        $senderBalance->amount += number_format($value, 2, '.', '');
        $transferSender = $senderBalance->save();

        $historicSender = $sender->historics()->create([
            'type'                => 'I', 
            'amount'              => $value, 
            'total_before'        => $senderTotalBefore, 
            'total_after'         => $senderBalance->amount, 
            'date'                => date('Y-m-d'),
            'user_id_transaction' => auth()->user()->id,
        ]);

        /**************************************************
        * EXECUTA O COMMIT OU ROLLBACK
        **************************************************/

        if ($transfer && $historic && $transferSender && $historicSender) {
            DB::commit();
            return [
                'success' => true,
                'message' => 'Transferência realizada com sucesso!'
            ];  
        }else{
            DB::rollback();
            return [
                'success' => false,
                'message' => 'Transferência não foi realizada.'
            ];
        }
    }
}
