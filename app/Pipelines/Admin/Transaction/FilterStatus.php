<?php
    namespace App\Pipelines\Admin\Transaction;

    use Closure;

    class FilterStatus
    {
        public function handle($request, Closure $next)
        {
            $data = $next($request);

            if (request()->has('status') && request('status') != '')
            {
                return  $data->Where('transactions.status',request('status'));
            }
            return $data;
        }
    }