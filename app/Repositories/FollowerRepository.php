<?php

namespace App\Repositories;

use App\Models\Follower;
use App\Models\Message;
use App\Support\Flag;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class FollowerRepository
{

    public function mid(int $id): string
    {
        $follower = Follower::find($id);

        return $follower->mid ?? "";
    }

    public function follow(string $mid): void
    {
        try {
            DB::beginTransaction();

            Follower::updateOrCreate(
                [
                    "mid" => $mid,
                ],
                [
                    "blocked_at" => null,
                ]
            );

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function unfollow(string $mid): void
    {
        try {
            DB::beginTransaction();

            Follower::updateOrCreate(
                [
                    "mid" => $mid,
                ],
                [
                    "blocked_at" => Carbon::now(),
                ]
            );

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
}
