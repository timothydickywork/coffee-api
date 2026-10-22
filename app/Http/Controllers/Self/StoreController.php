<?php

namespace App\Http\Controllers\Self;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Transformers\Self\StoreTransformer;
use App\Models\Self\Store;
use Cacing69\BITBuilder\FactoryBuilder;
use Cacing69\BITBuilder\Filterable;
use Cacing69\BITBuilder\Sortable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Exceptions\NotFoundException;
use App\Http\Requests\StoreRequest;

class StoreController extends Controller
{
	public function index(Request $request)
	{
		$factory = new FactoryBuilder();
		$data = $factory->on(Store::class)
			->addFilters([
				Filterable::exact('id', 'id')
			])
			->addSorts([
				Sortable::field('id'),
			])
			->defaultSort("id")
			->with("kodepos")
			->removeLimit()
			->get();

		$response = new Response();
		return $this->response->collection($data, new StoreTransformer, ["key" => "data"]);
	}

	public function store(StoreRequest $request)
	{
		DB::beginTransaction();
		try {
			$store = new Store();

			$store->name = $request->name;
			$store->phone = $request->phone;
			$store->address = $request->address;

			$store->save();

			DB::commit();
			$data = [
				"meta" => [
					"message"   => "save_store_success",
				],
				"data"      => null
			];

			return response()->json($data, 200);
		} catch (\Exception $e) {
			DB::rollback();
			throw new BadRequestException($e->getMessage());
		}
	}

	public function update(StoreRequest $request, $id)
	{
		DB::beginTransaction();
		try {
			if ($request->id != $id) {
				throw new BadRequestException("param_not_equal_to_body");
			}

			$store = Store::find($request->id);
			if (!$store) {
				throw new NotFoundException("store_not_found");
			}

			$store->name = $request->name;
			$store->phone = $request->phone;
			$store->address = $request->address;

			$store->save();

			DB::commit();
			$data = [
				"meta" => [
					"message"   => "edit_store_success",
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
			$store = Store::where("id", $id)
				->lockForUpdate()
				->first();

			if (!$store) {
				throw new NotFoundException("store_not_found");
			}

			$store->delete();
			DB::commit();

			$data = [
				"meta" => [
					"message"   => "delete_store_success",
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
