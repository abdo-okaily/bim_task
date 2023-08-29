<?php
    namespace App\Pipelines\Admin\Transaction;

    use Closure;

    class FilterDate
    {
        public function handle($request, Closure $next)
        {
            $data = $next($request);

            if (request()->has('from') && request('from') != '' && request()->has('to') && request('to') != '')
            {
                return  $data->whereBetween('transactions.created_at', [request('from'), request('to')]);
            }
            return $data;
        }
    }