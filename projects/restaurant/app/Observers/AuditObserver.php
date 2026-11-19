<?php
namespace App\Observers;
use App\Models\AuditLog;
class AuditObserver
{
    public function created($m)  { $this->log('created', $m); }
    public function updated($m)  { $this->log('updated', $m); }
    public function deleted($m)  { $this->log('deleted', $m); }
    private function log(string $action, $m): void
    {
        if ($m instanceof AuditLog) return;
        try {
            AuditLog::create([
                'user_id'    => auth()->id(),
                'action'     => $action,
                'model_type' => class_basename($m),
                'model_id'   => $m->getKey(),
                'summary'    => class_basename($m) . ' #' . $m->getKey() . ' ' . ($m->name ?? $m->order_no ?? $m->title ?? ''),
            ]);
        } catch (\Throwable $e) {}
    }
}