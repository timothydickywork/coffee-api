<?php

namespace App\Http\Controllers\Self;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Transformers\Self\CustomerTransformer;
use App\Models\Self\Customer;
use Cacing69\BITBuilder\FactoryBuilder;
use Cacing69\BITBuilder\Filterable;
use Cacing69\BITBuilder\Sortable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Exceptions\NotFoundException;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Customer\RegisterRequest;
use App\Http\Requests\Customer\LoginPasswordRequest;
use App\Http\Requests\Customer\LoginUidRequest;
use App\Http\Requests\Customer\ChangePasswordRequest;
use App\Http\Requests\Customer\ResetPasswordRequest;
use App\Http\Requests\Customer\CustomerRequest;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
	public function index(Request $request)
	{
		$factory = new FactoryBuilder();
		$data = $factory->on(Customer::class)
			->addFilters([
				Filterable::exact('code', 'code'),
				Filterable::exact('email', 'email'),
				Filterable::exact('uid', 'uid'),
				Filterable::like('name', 'name', Filterable::LIKE_BEGIN_END),
			])
			->addSorts([
				Sortable::field('code'),
				Sortable::field('name'),
			])
			->defaultSort("code")
			->removeLimit()
			->get();

		$response = new Response();
		return $this->response->collection($data, new CustomerTransformer, ["key" => "data"]);
	}

	public function loginPassword(LoginPasswordRequest $request)
	{
		$customer = Customer::where('email', $request->email)->first();
		if (!$customer) {
			throw new NotFoundException('email_not_registered');
		}
		if (Hash::check($request->password, $customer->password)) {
			$data = [
				"meta" => [
					"message"   => "login_success",
				],
				"data"      => null
			];

			return response()->json($data, 200);
		} else {
			throw new BadRequestException('login_failed');
		}
	}

	public function loginUid(LoginUidRequest $request)
	{
		$customer = Customer::where('email', $request->email)->first();
		if (!$customer) {
			throw new NotFoundException('email_not_registered');
		}
		if (Hash::check($request->uid, $customer->uid)) {
			$data = [
				"meta" => [
					"message"   => "login_success",
				],
				"data"      => null
			];

			return response()->json($data, 200);
		} else {
			throw new BadRequestException('login_failed');
		}
	}

	public function register(RegisterRequest $request)
	{
		DB::beginTransaction();
		try {
			$customer = new Customer();

			$customer->code = generate_code_customer();
			$customer->name = $request->name;
			$customer->password = Hash::make($request->password);
			$customer->email = $request->email;
			$customer->uid = Hash::make($request->uid);

			$customer->save();

			DB::commit();
			$data = [
				"meta" => [
					"message"   => "save_customer_success",
				],
				"data"      => null
			];

			return response()->json($data, 200);
		} catch (\Exception $e) {
			DB::rollback();
			throw new BadRequestException($e->getMessage());
		}
	}

	public function changePassword(ChangePasswordRequest $request)
	{
		DB::beginTransaction();
		try {
			$customer = Customer::where('email', $request->email)->first();
			if (!$customer) {
				throw new NotFoundException('email_not_registered');
			}
			if (Hash::check($request->old_password, $customer->password)) {
				// dd($customer);
				$customer->password = Hash::make($request->password);
				$customer->save();
				DB::commit();
				$data = [
					"meta" => [
						"message"   => "change_password_success",
					],
					"data"      => null
				];

				return response()->json($data, 200);
			} else {
				throw new BadRequestException('wrong_old_password');
			}
		} catch (NotFoundException $e) {
			DB::rollback();
			throw new NotFoundException($e->getMessage());
		} catch (\Exception $e) {
			DB::rollback();
			throw new BadRequestException($e->getMessage());
		}
	}

	public function resetPassword(ResetPasswordRequest $request)
	{
		DB::beginTransaction();
		try {
			$customer = Customer::where('email', $request->email)->first();
			if (!$customer) {
				throw new NotFoundException('email_not_registered');
			}
			$randomPassword = Str::random(12);
			$customer->password = Hash::make($randomPassword);
			$customer->save();
			DB::commit();
			$data = [
				"meta" => [
					"message"   => "change_password_success",
				],
				"data"      => [
					"new_password" => $randomPassword,
				]
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

	public function update(CustomerRequest $request, $code)
	{
		DB::beginTransaction();
		try {
			if ($request->code != $code) {
				throw new BadRequestException("param_not_equal_to_body");
			}

			$customer = Customer::find($request->code);
			if (!$customer) {
				throw new NotFoundException("customer_not_found");
			}

			$customer->name = $request->name;

			$customer->save();

			DB::commit();
			$data = [
				"meta" => [
					"message"   => "edit_customer_success",
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
