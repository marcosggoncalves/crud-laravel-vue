<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Exception;

class CategoryController extends Controller
{
    protected $repository;

    public function __construct(CategoryInterface $repository)
    {   
        $this->middleware(['auth']);

        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/categories",
     *      operationId="list_categories",
     *      tags={"categories"},
     *      summary="Listar Categorias",
     *      description="Retornar todos os categories cadastrados",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *      name="page",
     *      in="query",
     *       @OA\Schema(
     *           type="number"
     *       )
     *      ), 
     *      @OA\Response(
     *          response=200,
     *          description="Tudo certo!",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Não autorizado, login é necessário ou você não tem permissão! ",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Erro interno!",
     *           @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      )
     *   )
     */
    public function index()
    {
        try {
            $categories = $this->repository->index();

            return response()->json([
                'status' => true,
                'categories' => $categories
            ]);
        } catch (Exception $e) {
            return Response([
                'status' => false,
                'message' => 'Não foi possivel listar categories!',
                'error' => $e
            ], 500);
        }
    }
    /**
     * @OA\Post(
     ** path="/api/v1/categories",
     *   tags={"categories"},
     *   summary="Cadastrar Nova Categoria",
     *   operationId="new_categories",
     *   security={{"bearerAuth":{}}}, 
     * @OA\RequestBody(
     *    required=true,
     *    description="Campos para cadastros",
     *    @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="name", format="text", example="Veiculos Peças"),
     *    ),
     * ),   
     *   @OA\Response(
     *      response=200,
     *      description="Tudo Certo!",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *      description="Não autorizado, login é necessário ou você não tem permissão! "
     *   ),
     *    @OA\Response(
     *      response=417,
     *      description="Entradas inválidas, campos obrigatórios! "
     *   )
     *)
     **/
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:3|unique:categories,name'
            ]);

            if ($validator->fails()) {
                return  Response([
                    'status' => true,
                    'message' => 'Não foi possivel cadastrar nova categoria!',
                    'error' => $validator->errors()
                ], 417);
            }

            $categoria = $this->repository->store($request->all());

            return Response([
                'status' => true,
                'message' => 'Categoria cadastrada com sucesso!',
                'categoria' => $categoria
            ]);
        } catch (Exception $e) {
            return Response([
                'status' => false,
                'message' => 'Não foi possivel cadastrar nova categoria!',
                'error' => $e
            ], 500);
        }
    }
    /**
     * @OA\Put(
     ** path="/api/v1/categories/{id}",
     *   tags={"categories"},
     *   summary="Alterar cadastro da categoria",
     *   operationId="edit_categories",
     *   security={{"bearerAuth":{}}}, 
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="number"
     *      )
     *   ),
     *   @OA\RequestBody(
     *    required=true,
     *    description="Campos para cadastros",
     *    @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="name", format="text", example="Veiculos Peças"),
     *    ),
     *   ),
     *   @OA\Response(
     *      response=401,
     *      description="Não autorizado, login é necessário ou você não tem permissão! "
     *   ),
     *    @OA\Response(
     *      response=417,
     *      description="Entradas inválidas, campos obrigatórios! "
     *   )
     *)
     **/
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return  Response([
                    'status' => true,
                    'message' => 'Não foi possivel alterar informações cadastrais da categoria!',
                    'error' => $validator->errors()
                ], 417);
            }

            $this->repository->update($id, $request->all());

            return Response([
                'status' => true,
                'message' => 'Informações cadastrais alteradas com sucesso!'
            ]);
        } catch (Exception $e) {
            return Response([
                'status' => false,
                'message' => 'Não foi possivel alterar informações cadastrais da categoria!',
                'error' => $e
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     ** path="/api/v1/categories/{id}",
     *   tags={"categories"},
     *   summary="Excluir categoria",
     *   operationId="delete_categories",
     *   security={{"bearerAuth":{}}}, 
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="number"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *      description="Tudo Certo!",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *      description="Não autorizado, login é necessário ou você não tem permissão! "
     *   )
     *)
     **/
    public function destroy($id)
    {
        try {
            $deletarGrupo = $this->repository->destroy($id);

            if (!$deletarGrupo) {
                return Response()->json([
                    'status' => false,
                    'message' => 'Não foi possivel excluir o categoria!'
                ], 417);
            }

            return Response()->json([
                'status' => true,
                'message' => 'Categoria excluida com sucesso!'
            ]);
        } catch (Exception $e) {
            return Response()->json([
                'status' => false,
                'message' => 'Não foi possivel excluir categoria!',
                'error' => $e
            ], 500);
        }
    }
}
