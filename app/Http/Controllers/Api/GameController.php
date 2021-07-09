<?php

namespace App\Http\Controllers\Api;

use App\Helper\QueryHelper;
use App\Helper\SerialHelper;
use App\Http\Requests\GameRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
        $query = DB::table('games');
        QueryHelper::addConditions($query, $request, [
            QueryHelper::EqualSearch => ['uuid', 'type'],
            QueryHelper::FuzzySearch => ['code', 'chineseName', 'englishName'],
        ]);
        $query = $query->paginate();
        return GameResource::collection($query);
    }

    /**
     * 新增遊戲
     * @param GameRequest $request
     * @return GameResource
     */
    public function create(GameRequest $request)
    {
        $game = new Game();
        $game->chineseName = $request->chineseName;
        $game->englishName = $request->englishName;
        $game->type = $request->type;
        $game->code = SerialHelper::produce($request->type);
        $game->save();
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
        if ($game->type != $request->type) {
            $game->code = SerialHelper::produce($request->type);
        }
        $game->chineseName = $request->chineseName;
        $game->englishName = $request->englishName;
        $game->type = $request->type;
        $game->save();
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
            return response()->json(['success' => true, 'message' => $deleteName . ' 刪除成功！']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $deleteName . ' 刪除失敗，錯誤訊息' . $e->getMessage()], 500);
        }
    }
}
