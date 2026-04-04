<?php $cart = \Config\Services::cart(); ?>

<?php if(session("msg")):?>
   <div class="container alert alert-success text-center" style="width: 30%;">
      <?php echo session("msg"); ?>
      </div>
  <?php endif?>

<div class="container p-3 mb-2 text-white border-top border border-secondary rounded fondo2" style="width:80%;">

<div class="cart">
    <div class="heading">
        <u><i><h2 id="h2" align="center" style="color: #000000;">Productos en su Carrito</h2></i></u>
    </div>
    <br>

    <?php  
    // Si el carrito está vacio
    if (empty($carrito)):
    ?>
    <div class="text-center p-5">
        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="#6c757d" class="bi bi-cart" viewBox="0 0 16 16">
            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </svg>
        <h4 class="mt-3 text-muted">¡Tu carrito está vacío!</h4>
        <p class="text-muted">Para agregar productos al carrito, haz clic en "Comprar" en el catálogo.</p>
        
        <div class="mt-4">
            <a href="<?php echo base_url('catalogo'); ?>" class="btn btn-success btn-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bag-plus" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5z"/>
                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                </svg> Ir al Catálogo de Productos
            </a>
            
            <a href="<?php echo base_url('panel'); ?>" class="btn btn-outline-primary btn-lg ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
                    <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"/>
                </svg> Volver al Panel
            </a>
        </div>
    </div>
    
    <?php else: ?>
    <!-- CARRITO CON PRODUCTOS -->
    <table class="table" border="0" cellpadding="5px" cellspacing="1px">
        <tr id="main_heading" style="color: #1D94AC;">
            <td>ID</td>
            <td>Nombre</td>
            <td>Precio</td>
            <td>Cantidad</td>
            <td>Subtotal</td>
            <td>Eliminar?</td>
        </tr>

        <?php 
        echo form_open('carrito_actualiza');
        $gran_total = 0;
        $i = 1;

        foreach ($carrito as $item):
            echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
            echo form_hidden('cart[' . $item['id'] . '][rowid]', $item['rowid']);
            echo form_hidden('cart[' . $item['id'] . '][name]', $item['name']);
            echo form_hidden('cart[' . $item['id'] . '][price]', $item['price']);
            echo form_hidden('cart[' . $item['id'] . '][qty]', $item['qty']);
        ?>
            <tr style="color: white;">
                <td><?php echo $i++; ?></td>
                <td><?php echo $item['name']; ?></td>
                <td>$ARS <?php echo number_format($item['price'], 2); ?></td>
                <td>
                    <?php echo form_input('cart[' . $item['id'] . '][qty]', $item['qty'],
                                            'maxlength="3" size="1" style="text-align: right"'); ?>
                </td>
                <?php $gran_total = $gran_total + $item['subtotal']; ?>
                <td>$ARS <?php echo number_format($item['subtotal'], 2) ?></td>
                <td>
                    <?php 
                    $path = '<img src="'. base_url('assets/img/icons/basura3.png') . '" width="25px" height="20px">';
                    echo anchor('carrito_elimina/'. $item['rowid'], $path);
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>

        <tr>
            <td colspan="4" align="right">
                <b style="color: white;">Total: $<?php echo number_format($gran_total, 2); ?></b>
            </td>
            <td colspan="2" align="right">
                <!-- Borrar carrito usa mensaje de confirmacion javascript implementado en partes/head_view -->
                <input type="button" class="btn btn-outline-danger" value="Borrar carrito" onclick="borrar_carrito()">
                <!-- Submit boton. Actualiza los datos en el carrito -->
                <input type="submit" class="btn btn-outline-primary" value="Actualizar">
                <!-- " Confirmar orden envia a carrito_controller/muestra_compra  -->
                <input type="button" class="btn btn-outline-success" value="Continuar Compra" onclick="window.location = 'comprar'">
            </td>
        </tr>
        <?php echo form_close(); ?>
    </table>
    
    <div class="text-center mt-4">
        <a href="<?php echo base_url('catalogo'); ?>" class="btn btn-info">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg> Seguir Comprando
        </a>
    </div>
    
    <?php endif; ?>
</div>
</div>
<br><br><br><br><br><br><br><br><br>
