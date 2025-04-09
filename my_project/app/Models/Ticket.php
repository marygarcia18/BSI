<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'priority',
        'category',
        'admin_delete', 
    ];

    protected $with = ['user'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('adminNotDeleted', function ($query) {
            if (auth()->user() && auth()->user()->role === 'admin') {
                $query->where('admin_delete', 0);
            }
        });
    }

    // Scope for showing tickets for the user, including soft-deleted ones
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId)
                     ->orWhere(function ($query) use ($userId) {
                         // Include soft-deleted tickets for the user
                         $query->where('user_id', $userId)
                               ->where('admin_delete', 1); // Include soft-deleted tickets
                     });
    }

    // Soft delete method for users
    public function softDelete()
    {
        $this->admin_delete = true;
        $this->save();
    }

    // Permanent delete method for users (removes ticket from the database)
    public function permanentlyDelete()
    {
        $this->forceDelete();
    }
}