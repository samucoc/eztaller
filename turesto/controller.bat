@rem Controladores de mantenedores
@rem Autor: yo



@echo off
php artisan make:model Venta
php artisan make:model VentaDetalle
php artisan make:model Cuota
php artisan make:model Abono
php artisan make:model PrimerVencimiento
php artisan make:model Tramo
php artisan make:model DepositoPie
php artisan make:model PieVenta
php artisan make:model Aprobaciones
php artisan make:model RegistroFolioProblema
php artisan make:model RegistroFolioDicom
php artisan make:model VentasCambioSector
php artisan make:model RegistroFolioDevolucion
php artisan make:model Devolucion
php artisan make:model DevolucionDetalle
php artisan make:model CargaAutorizada
php artisan make:model CargaDespachada
php artisan make:model CargaEliminada
php artisan make:model CargaAprobada
php artisan make:model BajaVenta
php artisan make:model AumentoComision
php artisan make:model Traspaso
php artisan make:model DescuentoComision
php artisan make:model Clientes
php artisan make:model ComisionVendedor
php artisan make:model ComisionSupervisor
php artisan make:model ComisionCobrador
php artisan make:model SobranteCliente
php artisan make:model SobranteClienteAsignacion
php artisan make:model Deposito
php artisan make:model PieVendedor
php artisan make:model Descuentos

php artisan make:controller VentaController
php artisan make:controller VentaDetalleController
php artisan make:controller CuotaController
php artisan make:controller AbonoController
php artisan make:controller PrimerVencimientoController
php artisan make:controller TramoController
php artisan make:controller DepositoPieController
php artisan make:controller PieVentaController
php artisan make:controller AprobacionesController
php artisan make:controller RegistroFolioProblemaController
php artisan make:controller RegistroFolioDicomController
php artisan make:controller VentasCambioSectorController
php artisan make:controller RegistroFolioDevolucionController
php artisan make:controller DevolucionController
php artisan make:controller DevolucionDetalleController
php artisan make:controller CargaAutorizadaController
php artisan make:controller CargaDespachadaController
php artisan make:controller CargaEliminadaController
php artisan make:controller CargaAprobadaController
php artisan make:controller BajaVentaController
php artisan make:controller AumentoComisionController
php artisan make:controller TraspasoController
php artisan make:controller DescuentoComisionController
php artisan make:controller ClientesController
php artisan make:controller ComisionVendedorController
php artisan make:controller ComisionSupervisorController
php artisan make:controller ComisionCobradorController
php artisan make:controller SobranteClienteController
php artisan make:controller SobranteClienteAsignacionController
php artisan make:controller DepositoController
php artisan make:controller PieVendedorController
php artisan make:controller DescuentosController
