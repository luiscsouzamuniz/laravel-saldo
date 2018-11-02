<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Http\Requests\MoneyValidationFormRequest;
use App\User;
use App\Models\Historic;
class BalanceController extends Controller
{
    private $totalPage = 3;

    public function index()
    {
    	/**************************************************
        * RETORNAR A VIEW
        **************************************************/

    	$balance = auth()->user()->balance;

    	$amount = $balance ? $balance->amount : 0;

    	//retornar view
    	return view('admin.balance.index', compact('amount'));
    }

    public function deposit()
    {
    	/**************************************************
        * RETORNAR A VIEW
        **************************************************/

    	return view('admin.balance.deposit');
    }

    public function depositStore(MoneyValidationFormRequest $request)
    {
    	/**************************************************
        * METODO CONTROLADOR DE RECARGA
        **************************************************/

    	$balance = auth()->user()->balance()->firstOrCreate([]);
    	$response = $balance->deposit($request->value);

    	if ($response['success']) {
    		return redirect()
    			->route('balance')
    			->with('success', $response['message']);
    	}else{
    		return redirect()
    				->back()
    				->with('error', $response['message']);
    	}
    }

    public function withdraw()
    {
    	/**************************************************
        * RETORNAR A VIEW
        **************************************************/

    	return view('admin.balance.withdraw');
    }

    public function withdrawStore(MoneyValidationFormRequest $request)
    {
    	/**************************************************
        * METODO CONTROLADOR DE SAQUE
        **************************************************/

    	$balance = auth()->user()->balance()->firstOrCreate([]);
    	$response = $balance->withdraw($request->value);

    	if ($response['success']) {
    		return redirect()
    			->route('balance')
    			->with('success', $response['message']);
    	}else{
    		return redirect()
    				->back()
    				->with('error', $response['message']);
    	}
    }

    public function transfer()
    {
    	/**************************************************
        * RETORNAR A VIEW
        **************************************************/
    	return view('admin.balance.transfer');
    	
    }

    public function transferConfirm(Request $request, User $user)
    {
    	/**************************************************
        * METODO CONTROLADOR PARA CONFIRMAR DESTINATARIO
        **************************************************/

    	$balance = auth()->user()->balance;

    	if (!$sender = $user->getSender($request->sender)) {
    		return redirect()
    				->back()
    				->with('error', 'Usuário não encontrado');
    	}
    	elseif ($sender->id === auth()->user()->id) {
    		return redirect()
    				->back()
    				->with('error', 'Não é possível transferir para a conta remetente!');
    	}
    	else{
    		/**************************************************
        	* RETORNAR A VIEW
        	**************************************************/	
    		return view('admin.balance.transfer-confirm', compact('sender', 'balance'));
    	}
    }

    public function transferStore(MoneyValidationFormRequest $request, User $user)
    {
    	/**************************************************
        * METODO CONTROLADOR DE TRANSFERENCIA
        **************************************************/

    	if (!$sender = $user->find($request->sender_id)) {
    		return redirect()
    				->route('balance.transfer')
    				->with('error', 'Receptor não encontrado!');
    	}else{
    		$balance = auth()->user()->balance()->firstOrCreate([]);
	    	$response = $balance->transfer($request->value, $sender);

	    	if ($response['success']) {
	    		return redirect()
	    			->route('balance')
	    			->with('success', $response['message']);
	    	}else{
	    		return redirect()
	    				->back()
	    				->with('error', $response['message']);
	    	}
    	}
    }

     public function historic(Historic $historic)
    {

    	$historics = auth()->user()->historics()->with(['userSender'])->paginate($this->totalPage);

    	$types = $historic->type();

    	/**************************************************
        * RETORNAR A VIEW
        **************************************************/
    	return view('admin.balance.historics', compact('historics', 'types'));
    	
    }

    public function searchHistoric(Request $request, Historic $historic)
    {
    	$dataForm = $request->except('_token');

    	$historics = $historic->search($dataForm, $this->totalPage);

    	$types = $historic->type();

    	return view('admin.balance.historics', compact('historics', 'types', 'dataForm'));
    }
}
