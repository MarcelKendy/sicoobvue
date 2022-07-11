<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;


class AssociatesController extends Controller
{
    public function getAccounts(Request $request)
    {

        if (isset($request->select)) {
            $select = $request->select;
        } else {
            $select = '*';
        }
        if (isset($request->where)) {
            $where = $request->where;
        } else {
            $where = 'true';
        }
        if (isset($request->with)) {
            $with = $request->with;
        } else {
            $with = '';
        }
        $allAssociates = Account::select($select)->whereRaw($where)->with($with)->get();
        return response()->json($allAssociates);
    }

    public function addAccount(Request $request)
    {
        $newAccount = new Account();
        $newAccount->user_id = $request->user_id;
        $newAccount->associate = $request->associate;
        $newAccount->cpf_cnpj = $request->cpf_cnpj;
        $newAccount->phone = $request->phone;
        $newAccount->account = $request->account;
        $newAccount->account_type = $request->account_type;
        $newAccount->category = $request->category;
        $newAccount->group = $request->group;
        $newAccount->save();
        return response()->json($newAccount);
    }

    public function editAccount(Request $request)
    {
        $account = Account::find($request->original_cpf_cnpj);
        $account->user_id = $request->user_id;
        $account->associate = $request->associate;
        $account->cpf_cnpj = $request->cpf_cnpj;
        $account->phone = $request->phone;
        $account->account = $request->account;
        $account->account_type = $request->account_type;
        $account->category = $request->category;
        $account->group = $request->group;
        $account->save();
        return response()->json($account);
    }

    public function deleteAccount(Request $request)
    {
        return Account::find($request->cpf_cnpj)->delete();
    }
}
