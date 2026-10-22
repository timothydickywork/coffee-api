<?php

namespace App\Http\Controllers\Self;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Transformers\Self\SetupPointsTransformer;
use App\Models\Self\SetupPoints;
use Cacing69\BITBuilder\FactoryBuilder;
use Cacing69\BITBuilder\Sortable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Exceptions\NotFoundException;
use App\Http\Requests\SetupPointsRequest;

class SetupPointsController extends Controller
{
	public function now(Request $request)
	{
		$data = get_current_setup_points();
		$response = new Response();
		return response()->json($data, 200);
	}

	public function future(Request $request)
	{
		$now = Carbon::now()->isoFormat('YYYY-MM-DD');

		$factory = new FactoryBuilder();
		$data = $factory->on(SetupPoints::class)
			->addSorts([
				Sortable::field('id'),
			])
			->defaultSort('id')
			->where('start_date', '>', $now)
			->removeLimit()
			->get();

		$response = new Response();
		return $this->response->collection($data, new SetupPointsTransformer, ["key" => "data"]);
	}

	public function history(Request $request)
	{
		$now = Carbon::now()->isoFormat('YYYY-MM-DD');

		$current = get_current_setup_points();

		$factory = new FactoryBuilder();
		$data = $factory->on(SetupPoints::class)
			->addSorts([
				Sortable::field('id'),
			])
			->defaultSort('id')
			->where('start_date', '<', $now)
			->where('id', '<>', $current->id)
			->removeLimit()
			->get();

		$response = new Response();
		return $this->response->collection($data, new SetupPointsTransformer, ["key" => "data"]);
	}

	public function store(SetupPointsRequest $request)
	{
		DB::beginTransaction();
		try {
			$setupPoints = new SetupPoints();

			$setupPoints->min_transaction = $request->min_transaction;
			$setupPoints->start_date = $request->start_date;
			$setupPoints->expiration_day = $request->expiration_day;

			$setupPoints->save();

			DB::commit();
			$data = [
				"meta" => [
					"message"   => "save_setup_points_success",
				],
				"data"      => null
			];

			return response()->json($data, 200);
		} catch (\Exception $e) {
			DB::rollback();
			throw new BadRequestException($e->getMessage());
		}
	}

	public function update(SetupPointsRequest $request, $id)
	{
		DB::beginTransaction();
		try {
			$now = Carbon::now()->isoFormat('YYYY-MM-DD');

			if ($request->id != $id) {
				throw new BadRequestException("param_not_equal_to_body");
			}
			$setupPoints = SetupPoints::find($request->id);
			if (!$setupPoints) {
				throw new NotFoundException("setup_points_not_found");
			}

			if ($setupPoints->start_date <= $now) {
				throw new BadRequestException("history_setup_points_should_not_update");
			}

			$setupPoints->min_transaction = $request->min_transaction;
			$setupPoints->start_date = $request->start_date;
			$setupPoints->expiration_day = $request->expiration_day;

			$setupPoints->save();

			DB::commit();
			$data = [
				"meta" => [
					"message"   => "edit_setup_points_success",
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

	public function delete($id)
	{
		DB::beginTransaction();
		try {
			$now = Carbon::now()->isoFormat('YYYY-MM-DD');
			$setupPoints = SetupPoints::where("id", $id)
				->lockForUpdate()
				->first();

			if (!$setupPoints) {
				throw new NotFoundException("setup_points_not_found");
			}

			if ($setupPoints->start_date <= $now) {
				throw new BadRequestException("history_setup_points_should_not_delete");
			}

			$setupPoints->delete();
			DB::commit();

			$data = [
				"meta" => [
					"message"   => "delete_setup_points_success",
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
