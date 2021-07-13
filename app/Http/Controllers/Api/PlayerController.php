<?php

namespace App\Http\Controllers\Api;

use App\Enum\UserRoleEnum;
use App\Helper\QueryHelper;
use App\Http\Requests\PlayerRequest;
use App\Http\Resources\PlayerResource;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PlayerController extends Controller
{

    /**
     * 列出玩家
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list(Request $request)
    {
        $query = DB::table('users');
        $query = $query->where(['role' => UserRoleEnum::PLAYER]);
        QueryHelper::addConditions($query, $request, [
            QueryHelper::EqualSearch => ['uuid', 'currency'],
            QueryHelper::FuzzySearch => ['name', 'email'],
        ]);
        $query = $query->paginate();
        return PlayerResource::collection($query);
    }

    /**
     * 新增玩家
     * @param PlayerRequest $request
     * @return PlayerResource
     */
    public function create(PlayerRequest $request)
    {
        $player = User::create([
            'name' => $request->name,
            'role' => UserRoleEnum::PLAYER,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'currency' => $request->currency,
        ]);
        return new PlayerResource($player);
    }

    /**
     * 更新玩家
     * @param PlayerRequest $request
     * @return PlayerResource
     */
    public function update(PlayerRequest $request)
    {
        $player = User::where(['uuid' => $request->uuid])->first();
        $player->update($request->all());
        return new PlayerResource($player);
    }

    /**
     * 刪除玩家
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $deleteName = '玩家 ';
        try {
            $player = User::where(['uuid' => $request->uuid])->first();
            $deleteName .= "{$player->name} ( {$player->email} )";
            $player->delete();
            return response()->json(['success' => true, 'message' => $deleteName . ' 刪除成功！', 'data' => null]);
        } catch (\Exception $e) {
            return response()->json(['success' => true, 'message' => $deleteName . ' 刪除失敗，錯誤訊息' . $e->getMessage(), 'data' => null], 500);
        }
    }
}
