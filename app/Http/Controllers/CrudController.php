<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CrudController extends Controller 
{
	protected $model;
	protected $validacoes;
	protected $relacionamentos;
	protected $nomePlural;
	protected $nomeSingular;

	protected function index()
	{
		$this->data["{$this->nomePlural}"] = $this->model->all();
		return view("admin.{$this->nomePlural}.index", $this->data);
	}

	protected function cadastrar()
	{
		$this->data["{$this->nomeSingular}"] = null;

		return view("admin.{$this->nomePlural}.form", $this->data);
	}

	protected function registrar(Request $request)
	{
		$validator = Validator::make($request->all(), $this->validacoes);

		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

		$resultado = $this->model->registrar($request);

		if ($resultado) {
			return response()->json([
				'sucesso' => 'true',
				'retorno' => 'Cadastrado com sucesso'
			]);
		} else {
			return response()->json([
				'sucesso' => 'false',
				'retorno' => 'Erro ao cadastrar, tente novamente mais tarde'
			]);
		}
	}

	protected function alterar($id)
	{
		$this->data["{$this->nomeSingular}"] = $this->model->find($id);

		return view("admin.{$this->nomePlural}.form", $this->data);
	}

	protected function atualizar(Request $request)
	{
		$validator = Validator::make($request->all(), $this->validacoes);

		if ($validator->fails()) {
			throw new ValidationException($validator);
		}

		$resultado = $this->model->registrar($request);

		if ($resultado) {
			return response()->json([
				'sucesso' => 'true',
				'retorno' => 'Atualizado com sucesso'
			]);
		} else {
			return response()->json([
				'sucesso' => 'false',
				'retorno' => 'Erro ao atualizar, tente novamente mais tarde'
			]);
		}
	}

	protected function excluir($id)
	{
		$resultado = $this->model->excluir($id);

		if ($resultado) {
			return response()->json([
				'sucesso' => 'true',
				'retorno' => 'Excluído com sucesso'
			]);
		} else {
			return response()->json([
				'sucesso' => 'false',
				'retorno' => 'Erro ao excluir, tente novamente mais tarde'
			]);
		}
	}
}