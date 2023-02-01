<?php

namespace App\Http\Controllers\Voucher;

use App\Exceptions\AuthenticateException;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware("token");
    }

    public function lista(Request $request)
    {

        $idusuario = Helper::tokenDecode($request->bearerToken());

        $user = DB::selectOne("SELECT
            u.idusuario,
            u.apellido,
            u.nombre,
            u.email,
            co.id_contribuyente,
            co.ruc,
            co.razon_social,
            co.tipo_envio_sunat,
            ro.id_rol,
            ro.nombre,
            su.idsucursal,
            su.codigo,
            su.nombre AS sucursal
        FROM usuario AS u 
            INNER JOIN contribuyente AS co ON co.id_contribuyente = u.id_contribuyente
            INNER JOIN rol_usuario AS ro ON ro.id_rol = u.id_rol
            INNER JOIN sucursal AS su ON su.idsucursal = u.idsucursal
        WHERE u.idusuario = ?", [$idusuario]);

        if (is_null($user)) {
            throw new AuthenticateException('Lo sentimos! Debes generar un código, no se permite compos vacíos.');
        }

        if (is_null($request->paginacion)) {
            throw new AuthenticateException('El parámetro paginación debe incluirse.');
        }

        if (is_null($request->filasPorPagina)) {
            throw new AuthenticateException('El parámetro filas por página debe incluirse.');
        }

        // $rol = DB::table('rol_usuario')->where("id_rol", $user->id_rol)->first();
        // if (is_null($rol)) {
        //     throw new AuthenticateException('Error en obtener los roles.');
        // }

        // $contribuyente = DB::table('contribuyente')->where("id_contribuyente", $user->id_contribuyente)->first();
        // if (is_null($contribuyente)) {
        //     throw new AuthenticateException('Error en obtener los datos del contribuyente.');
        // }


        $ventas = DB::select("SELECT
            de.id_contribuyente,
            de.id_tipodoc_electronico,
            de.tipo_envio_sunat,
            CAST(de.fecha_registro AS DATE) AS fecha_registro,
            CAST(de.fecha_registro AS TIME) AS hora_registro,
            de.serie_comprobante,
            de.numero_comprobante,
            std.descripcion,
            IFNULL(cpago.condicionpago,'') AS condicionpago,
            clie.num_doc,
            clie.razon_social,
            m.simbolo,
            de.total
        FROM doc_electronico AS de
            INNER JOIN sunat_tipodocelectronico AS std ON std.id_tipodoc_electronico = de.id_tipodoc_electronico
            INNER JOIN cliente AS clie ON de.idcliente = clie.idcliente
            INNER JOIN sunat_moneda AS m ON m.id_codigomoneda = de.id_codigomoneda
            LEFT JOIN condiciondepago AS cpago ON cpago.id_condicionpago = de.id_condicionpago
        WHERE
            de.id_contribuyente = ?
            AND de.tipo_envio_sunat = ?
            AND de.id_tipodoc_electronico IN('01', '03', '07', '08')
            AND de.id_sucursal = ?
            AND de.id_vendedor = ?
            AND (
                ? = 0  
                AND CAST(de.fecha_registro AS DATE) >= '2022-01-01'
                AND CAST(de.fecha_registro AS DATE) <= '2023-01-31'

                OR

                ? = 1 AND (
                    clie.num_doc = ?
                    OR
                    clie.razon_social LIKE CONCAT('%',?,'%')
                    OR
                    de.serie_comprobante = ?
                    OR
                    de.numero_comprobante = ?
                    OR
                    CONCAT(de.serie_comprobante,'-',de.numero_comprobante ) = ?
                )
            )
        ORDER BY
            fecha_registro DESC,
            hora_registro DESC
        LIMIT ?,?", [
            $user->id_contribuyente,
            $user->tipo_envio_sunat,
            $user->idsucursal,
            $user->idusuario,

            intval($request->opcion),

            intval($request->opcion),
            $request->busqueda,
            $request->busqueda,
            $request->busqueda,
            $request->busqueda,
            $request->busqueda,

            intval($request->paginacion),
            intval($request->filasPorPagina)
        ]);


        if (count($ventas) > 0) {
            array_map(function ($item, $index) use ($request) {
                $venta = $item;
                $venta->id = $index + intval($request->paginacion);
                $venta->pdf = env("APP_URL_PDF") . "/facturacion/printpdf/?file=" . Helper::encriptar($item->id_contribuyente . "||" . $item->id_tipodoc_electronico . "||" . $item->serie_comprobante . "||" . $item->numero_comprobante . "||" . $item->tipo_envio_sunat . "||a4");
                $venta->ticket = env("APP_URL_PDF") . "/facturacion/printpdf/?file=" . Helper::encriptar($item->id_contribuyente . "||" . $item->id_tipodoc_electronico . "||" . $item->serie_comprobante . "||" . $item->numero_comprobante . "||" . $item->tipo_envio_sunat . "||ticket");
                return $venta;
            }, $ventas, range(1, count($ventas)));
        }

        $total = DB::selectOne("SELECT COUNT(*) AS total
        FROM doc_electronico AS de
            INNER JOIN sunat_tipodocelectronico AS std ON std.id_tipodoc_electronico = de.id_tipodoc_electronico
            INNER JOIN cliente AS clie ON de.idcliente = clie.idcliente
            INNER JOIN sunat_moneda AS m ON m.id_codigomoneda = de.id_codigomoneda
            LEFT JOIN condiciondepago AS cpago ON cpago.id_condicionpago = de.id_condicionpago
        WHERE
            de.id_contribuyente = ?
            AND de.tipo_envio_sunat = ?
            AND de.id_tipodoc_electronico IN('01', '03', '07', '08')
            AND de.id_sucursal = ?
            AND de.id_vendedor = ?
            AND (
                ? = 0  
                AND CAST(de.fecha_registro AS DATE) >= '2022-01-01'
                AND CAST(de.fecha_registro AS DATE) <= '2023-01-31'

                OR

                ? = 1 AND (
                    clie.num_doc = ?
                    OR
                    clie.razon_social LIKE CONCAT('%',?,'%')
                    OR
                    de.serie_comprobante = ?
                    OR
                    de.numero_comprobante = ?
                    OR
                    CONCAT(de.serie_comprobante,'-',de.numero_comprobante ) = ?
                )
            )", [
            $user->id_contribuyente,
            $user->tipo_envio_sunat,
            $user->idsucursal,
            $user->idusuario,

            intval($request->opcion),

            intval($request->opcion),
            $request->busqueda,
            $request->busqueda,
            $request->busqueda,
            $request->busqueda,
            $request->busqueda,
        ]);

        return response()->json([
            "message" => "ok",
            "ventas" => $ventas,
            "total" => is_null($total) ? 0 : $total->total,
        ]);
    }
}
