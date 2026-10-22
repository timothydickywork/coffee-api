<?php

namespace App\Http\Controllers\Self;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Transformers\Self\TransactionTransformer;
use App\Models\Self\Transaction;
use Cacing69\BITBuilder\FactoryBuilder;
use Cacing69\BITBuilder\Filterable;
use Cacing69\BITBuilder\Sortable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Exceptions\NotFoundException;
use App\Http\Requests\TransactionRequest;
use App\Http\Requests\DeleteRequest;
use App\Models\Self\PointsAddiction;
use Carbon\Carbon;

class TransactionController extends Controller
{
	public function index(Request $request)
	{
		$factory = new FactoryBuilder();
		$data = $factory->on(Transaction::class)
			->addFilters([
				Filterable::exact("store_id", "store_id"),
				Filterable::exact("customer_code", "customer_code"),
				Filterable::greaterThanEqual("date", "date"),
			])
			->addSorts([
				Sortable::field('date'),
			])
			->defaultSort('date')
			->with('store')
			->with('pointsAddiction')
			->with('customer')
			->removeLimit()
			->get();

		$response = new Response();
		return $this->response->collection($data, new TransactionTransformer, ["key" => "data"]);
	}

	public function store(TransactionRequest $request)
	{
		DB::beginTransaction();
		try {
			$now = Carbon::now();
			$transaction = new Transaction();

			$transaction->store_id = $request->store_id;
			$transaction->transaction_number = $request->transaction_number;
			$transaction->customer_code = $request->customer_code;
			$transaction->amount = $request->amount;
			$date = new Carbon($request->date);
			// dd($date);
			$transaction->date = $date;

			$transaction->save();

			$currentSetupPoints = get_current_setup_points();
			if ($currentSetupPoints->min_transaction < $transaction->amount && $request->customer_code != 'NonMember') {
				$pointsAddiction = new PointsAddiction();

				$pointsAddiction->setup_points_id = $currentSetupPoints->id;
				$pointsAddiction->transaction_id = $transaction->id;
				$pointsAddiction->transaction_number = $transaction->transaction_number;
				if (isset($request->customer_code))
					$pointsAddiction->customer_code = $request->customer_code;
				$pointsAddiction->date = $now;
				$pointsAddiction->expired_date = Carbon::now()->addDays($currentSetupPoints->expiration_day);
				$pointsAddiction->points_added = (int) ($transaction->amount / $currentSetupPoints->min_transaction);
				$pointsAddiction->points_active = $pointsAddiction->points_added;

				$pointsAddiction->save();
			}

			DB::commit();
			$data = [
				"meta" => [
					"message"   => "save_transaction_success",
				],
				"data"      => null
			];

			return response()->json($data, 200);
		} catch (\Exception $e) {
			DB::rollback();
			throw new BadRequestException($e->getMessage());
		}
	}

	public function delete(DeleteRequest $request, $id)
	{
		DB::beginTransaction();
		try {
			if ($request->id != $id) {
				throw new BadRequestException("param_not_equal_to_body");
			}
			$transaction = Transaction::where("id", $id)
				->first();

			if (!$transaction) {
				throw new NotFoundException("transaction_not_found");
			}

			$transaction->delete_reason = $request->delete_reason;
			$transaction->save();

			$pointsAddiction = PointsAddiction::where("transaction_id", $id)
				->first();

			if ($pointsAddiction) {
				$pointsAddiction->delete();
			}

			$transaction->delete();
			DB::commit();

			$data = [
				"meta" => [
					"message"   => "delete_transaction_success",
				],
				"data"      => null
			];

			return response()->json($data, 200);
		} catch (NotFoundException $e) {
			DB::rollback();
			throw new NotFoundException($e->getMessage());
		} catch (\Exception $e) {
			DB::rollback();
			throw new BadRequestException($e->getMessage());
		}
	}
}
