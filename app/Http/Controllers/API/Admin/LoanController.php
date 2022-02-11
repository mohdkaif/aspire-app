<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\APIResponse;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    use APIResponse;

    public function change_loan_request_status(Request $request, $id)
    {
        try {
            if (Auth::user()->role_type != 'admin') {
                return $this->error(false, 'You are not admin user.');
            }

            $loan_update = Loan::find($id);
            $loan_update->status = $request->status;
            if ($request->status == 'approved') {
                $date = now()->addDays(7)->format('Y-m-d');
                $loan_update->next_payment_date = $date;
            }
            $loan_update->save();

            ////////We can Send Mail to user Here  to inform for approved or decline his loan request.

            return $this->success($loan_update, true, 'Loan Status changed as ' . $request->status);
        } catch (\Exception $e) {
            throw $e;
            return $this->failure(500, "Something went wrong!");
        }
    }

    public function loan_list(Request $request)
    {
        try {
            if (Auth::user()->role_type != 'admin') {
                return $this->error(false, 'You are not admin user.');
            }

            $loan = Loan::get();
            return $this->success($loan, true, 'Loan  List  fetched successfully.');
        } catch (\Exception $e) {
            throw $e;
            return $this->failure(500, "Something went wrong!");
        }
    }

    public function loan_details(Request $request, $id)
    {
        try {
            if (Auth::user()->role_type != 'admin') {
                return $this->error(false, 'You are not admin user.');
            }
            $loan =  Loan::find($id);
            return $this->success($loan, true, 'Loan details fetched successfully.');
        } catch (\Exception $e) {
            throw $e;
            return $this->failure(500, "Something went wrong!");
        }
    }
}
