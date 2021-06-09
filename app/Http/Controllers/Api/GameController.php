<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\GameRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 列出遊戲
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list(Request $request)
    {
        $query = new Game();
        if ($request->uuid) {
            $query = $query->where(['uuid' => $request->uuid]);
        }
        if ($request->type) {
            $query = $query->where(['type' => $request->type]);
        }
        if ($request->code) {
            $query = $query->where('code', 'LIKE', "%$request->code%");
        }
        if ($request->gameName) {
            $query = $query->where(function ($query) use ($request) {
                $query->where('chineseName', 'LIKE', "%$request->gameName%")
                    ->orWhere('englishName', 'LIKE', "%$request->gameName%");
            });
        }
        $query = $query->paginate(6);
        return GameResource::collection($query);
    }

    /**
     * 建立遊戲
     * @param GameRequest $request
     * @return GameResource
     */
    public function create(GameRequest $request)
    {
        $game = Game::create($request->all());
        return new GameResource($game);
    }

    /**
     * 更新遊戲
     * @param GameRequest $request
     * @return GameResource
     */
    public function update(GameRequest $request)
    {
        $game = Game::where(['uuid' => $request->uuid])->first();
        $game->update($request->all());
        return new GameResource($game);
    }

    /**
     * 刪除遊戲
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $deleteName = '遊戲 ';
        try {
            $game = Game::where(['uuid' => $request->uuid])->first();
            $deleteName .= "{$game->code} - {$game->chineseName} ( {$game->englishName} )";
            $game->delete();
            return response()->json(['success' => true, 'message' => $deleteName . ' 刪除成功！', 'data' => null]);
        } catch (\Exception $e) {
            return response()->json(['success' => true, 'message' => $deleteName . ' 刪除失敗，錯誤訊息' . $e->getMessage(), 'data' => null], 500);
        }
    }
}
