<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController; 
use App\Http\Controllers\TamanoController; 
use App\Http\Controllers\PrecioController;
use App\Http\Controllers\NumCajaController;
use App\Http\Controllers\TrabajadoreController;
use App\Http\Controllers\TpProductoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\TpPedidoController;
use App\Http\Controllers\EstadoPedidoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoPedidoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedioPagoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TurnoController;
use App\Http\Controllers\HistorialVentasController;
use App\Http\Controllers\CierreCajaController;
use App\Http\Controllers\FacturaController;
use Illuminate\Support\Facades\Artisan;

Route::get('/run-migrations', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return '✅ Migraciones ejecutadas correctamente.';
    } catch (\Exception $e) {
        return '❌ Error al ejecutar migraciones: ' . $e->getMessage();
    }
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // --- Perfil ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Productos ---
    Route::resource('/productos', ProductoController::class);
    Route::resource('/tp-productos', TpProductoController::class);
    Route::resource('precios', PrecioController::class);
    Route::get('/productos/buscar', [PrecioController::class, 'buscarProducto'])->name('productos.buscar');

    // --- Cajas ---
    Route::resource('num-cajas', NumCajaController::class);
    Route::resource('cajas', CajaController::class);

    // --- Pedidos ---
   Route::resource('pedidos', PedidoController::class)->except(['show']);
    Route::resource('tp-pedidos', TpPedidoController::class);
    Route::resource('estado-pedidos', EstadoPedidoController::class);
    Route::get('/pedidos/{id}', [PedidoController::class, 'show'])->name('pedidos.Show');
    Route::post('/pedidos/completar/{id}', [PedidoController::class, 'completar'])->name('pedidos.completar');
    
    // --- Producto-Pedidos ---
    Route::resource('producto-pedidos', ProductoPedidoController::class)->except(['show', 'create']);
    Route::get('/producto-pedidos/create/{pedido}', [ProductoPedidoController::class, 'create'])->name('producto-pedidos.create');
    Route::get('/producto-pedidos/show/{pedido}', [ProductoPedidoController::class, 'show'])->name('producto-pedidos.show');
    Route::delete('producto-pedidos/{producto_pedido}', [ProductoPedidoController::class, 'destroy'])->name('producto-pedidos.destroy');

    // --- Ventas ---
    Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('/ventas/{venta}/edit', [VentaController::class, 'edit'])->name('ventas.edit');
    Route::put('/ventas/{venta}', [VentaController::class, 'update'])->name('ventas.update');
    Route::delete('/ventas/{venta}', [VentaController::class, 'destroy'])->name('ventas.destroy');
    Route::get('/ventas/historial', [HistorialVentasController::class, 'historialVentasPorCaja'])->name('ventas.historial');
    Route::get('/ventas/totales', [HistorialVentasController::class, 'totales'])->name('ventas.totales');
    Route::get('/ventas/create/{pedidoId}', [VentaController::class, 'create'])->name('ventas.create');
    
    // --- Clientes ---
    Route::resource('clientes', ClienteController::class)->except(['show']);
    Route::get('/clientes/{id}', [ClienteController::class, 'show'])->name('clientes.show');

    // --- Tamaños ---
    Route::resource('tamanos', TamanoController::class);

    // --- Turnos ---
    Route::get('/turno/seleccionar', [TurnoController::class, 'index'])->name('turno.seleccionar');
    Route::post('/turno/guardar', [TurnoController::class, 'guardarTurno'])->name('turno.guardar');
    
    // --- Historial de Ventas ---
    Route::get('/historial/productos/{id_caja}/{turno}/{fecha}', [HistorialVentasController::class, 'productosDeVenta'])->name('historial.productos');

    // --- Cierre de Caja ---
    Route::get('cierres-caja/{id}', [NumCajaController::class, 'cierreCajaForm'])->name('cierres_caja.index');
    Route::post('cierres-caja/{id}', [NumCajaController::class, 'cierreCaja'])->name('cierres_caja.store');

    // --- Trabajadores ---
    Route::resource('trabajadores', TrabajadoreController::class);

    // --- Precios ---
    Route::post('/productos/{producto}/precios/{precio}/update', [PrecioController::class, 'update'])->name('productos.precios.update');
    Route::post('/precios/inactivar/{id}', [PrecioController::class, 'inactivar'])->name('precios.inactivar');
    Route::post('/precios/{id}/activar', [PrecioController::class, 'activar'])->name('precios.activar');
    
    // --- Dashboard ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // medio de pago
    Route::resource('medio-pagos', MedioPagoController::class);
    Route::get('/ventas/detalle/{fecha}/{turno}/{id_caja}', [HistorialVentasController::class, 'detalleVenta'])->name('ventas.detalle');

});


require __DIR__.'/auth.php';