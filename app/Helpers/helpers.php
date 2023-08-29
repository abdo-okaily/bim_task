<?php

    use Illuminate\Support\Str;
    use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
    use App\Models\Transaction;
    use App\Models\Order;

    if(!function_exists('uploadFile'))
    {
        function uploadFile($file, $stringPath)
        {
            $file = $file;
            $fileName = time() . rand(1000, 10000) . '.' . $file->getClientOriginalExtension();
            $fileLocation = getcwd() . '/' . $stringPath . '/';
            $file->move($fileLocation, $fileName);
            if(!$file)
            {
                return FALSE;
            }
            return $fileName;
        }
    }
    if(!function_exists('generateRandomString'))
    {
        function generateRandomString($length = 10)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++)
            {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
    }
    if(!function_exists('routeIndex'))
    {
        /**
         * Generate a route name for the previous request.
         *
         * @return string|null
         */
        function routeIndex()
        {
            $url = explode("admin/", url()->current());
            $url = url("/") . "/admin/" . explode("/", $url[1])[0];
            $currentRequest = app('request')->create($url);
            // try {
            $routeName = app('router')->getRoutes()->match($currentRequest)->getName();
            // } catch (NotFoundHttpException $exception) {
            //     return ['routeName' => '', 'routeUrl' => $url];
            // }
            return ['routeName' => $routeName, 'routeUrl' => $url];
        }
    }
    //TODO: this function need to replaced with something more accurate and implement good performance
    if(!function_exists('orderCode'))
    {
        function orderCode(): string
        {
            do {
                $code = rand(111111, 999999) . substr(time(), -6);
            } while (Order::where("code", "=", $code)->first());

            return $code;
        }
    }
    //TODO: this function need to replaced with something more accurate and implement good performance
    if(!function_exists('transactionCode'))
    {
        function transactionCode(): string
        {
            do {
                $code = rand(111111, 999999) . substr(time(), -6);
            } while (Transaction::where("code", "=", $code)->first());

            return $code;
        }
    }
    if(!function_exists('amountInSar'))
    {
        function amountInSar(float $amount): float
        {
            return $amount / 100;
        }
    }
    if(!function_exists('amountInHalala'))
    {
        function amountInHalala(float $amountSar): float
        {
            return $amountSar * 100;
        }
    }
?>