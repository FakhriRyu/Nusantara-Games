<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['game_id','comment','rating'];

    public function game(): BelongsTo{
        return $this->belongsTo(Game::class);
    }

    public function getgamename(){
        $game = Game::join('games', 'game_id', '=', 'games.game_id')
        ->where('games.id',$this->id)
        ->first();

        return $game ? $game->title : null ;
    }
}
