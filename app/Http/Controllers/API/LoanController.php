<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Http\Traits\APIResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    use APIResponse;

    public function loan_request(Request $request)
    {
        try {

            $loanData = $request->all();
            $validator = Validator::make(
                $request->all(),
                [
                    'amount' => 'required|numeric',
                    'duration' => 'required|numeric'
                ]
            );
            if ($validator->fails()) {
                return $this->error(false, $validator->errors());
            }

            $loanData['user_id'] = Auth::user()->id;
            $loanData['repayment_frequency'] = $request->duration;
            $loanData['interest_rate'] = 5;
            $intrest_amount = 5 * $request->amount / 100;
            $amount_with_intrest = $intrest_amount + $request->amount;
            $weekly_pay_amount = $amount_with_intrest / $request->duration;
            $loanData['amount_with_intrest'] = $amount_with_intrest;
            $loanData['weekly_pay_amount'] = $weekly_pay_amount;

            ////////We can Send Mail to user Here but as of now i am not using email.

            $loan = Loan::create($loanData);
            return $this->success($loan, true, 'Loan Request created successfully.');
        } catch (\Exception $e) {
            throw $e;
            return $this->failure(500, "Something went wrong!");
        }
    }

    public function make_payment(Request $request, $loan_id)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'amount' => 'required|numeric',
                ]
            );
            if ($validator->fails()) {
                return $this->error(false, $validator->errors());
            }

            $loan = Loan::where(['id' => $loan_id, 'status' => 'approved'])->first();
            if (empty($loan)) {
                return $this->error(false, 'no active loan record found');
            }
            if ($loan->weekly_pay_amount != $request->amount) {
                return $this->error(false, 'Your payment amount should be equal to ' . $loan->weekly_pay_amount);
            }
            $loan_update = Loan::find($loan_id);
            $payment = [];
            $total_amount = 0;
            $sub_total_amount = 0;
            if (!empty($loan->payment_history)) {

                $payment_history = $loan->payment_history;
                $total_count = count((array)$payment_history);
                $count = $total_count + 1;
                foreach ($payment_history as $key => $paid) {
                    $old_payment[$key]['id'] = $paid['id'];
                    $old_payment[$key]['amount'] = $paid['amount'];
                    $old_payment[$key]['pay_date'] = $paid['pay_date'];
                    $old_payment[$key]['paid'] = true;
                    $old_payment[$key]['currency'] = 'USD';
                    $total_amount += $paid['amount'];
                }

                $new_payment[$count]['id'] = $count;
                $new_payment[$count]['amount'] = $request->amount;
                $new_payment[$count]['pay_date'] = date('Y-m-d');
                $new_payment[$count]['paid'] = true;
                $new_payment[$count]['currency'] = 'USD';
                $payment = array_merge($old_payment, $new_payment);
                $sub_total_amount = $total_amount + $request->amount;
            } else {
                $count = 0;
                $payment[$count]['id'] = $count + 1;
                $payment[$count]['amount'] = $request->amount;
                $payment[$count]['pay_date'] = date('Y-m-d');
                $payment[$count]['paid'] = true;
                $payment[$count]['currency'] = 'USD';
                $sub_total_amount = $request->amount;
            }
            $loan_update->payment_history = $payment;
            $ongoing_payment_date = Carbon::createFromFormat('Y-m-d', $loan_update->next_payment_date);
            $date =  $ongoing_payment_date->addDays(7)->format('Y-m-d');
            $loan_update->next_payment_date = $date;
            $loan_update->save();
            if ($sub_total_amount >= $loan->amount_with_intrest) {
                $loan_update = Loan::find($loan_id);
                $loan_update->status = 'completed';
                $loan_update->save();
                return $this->success($loan_update, 200, 'You have succesfully  completed your Loan.');
            }
            ////////We can Send Mail to user Here  to inform for suubmit payment or completed his loan payment.

            return $this->success($loan_update, 200, 'Loan  payment updated successfully.');
        } catch (\Exception $e) {
            throw $e;
            return $this->failure(500, "Something went wrong!");
        }
    }

    public function loan_list(Request $request)
    {
        try {
            $loan =  Loan::where('user_id', Auth::user()->id)->get();
            return $this->success($loan, true, 'Loan  List fetched successfully.');
        } catch (\Exception $e) {
            throw $e;
            return $this->failure(500, "Something went wrong!");
        }
    }

    public function loan_details(Request $request, $id)
    {
        try {
            $loan =  Loan::find($id);
            return $this->success($loan, true, 'Loan  details fetched successfully.');
        } catch (\Exception $e) {
            throw $e;
            return $this->failure(500, "Something went wrong!");
        }
    }
}
