<div class="container p-3 mb-2 text-dark border-top border border-secondary rounded fondo2" style="width:90%;">
    <div class="heading">
        <u><i><h2 id="h2" align="center" style="color: #000000;">Bandeja de Entrada: Consultas Pendientes</h2></i></u>
    </div>
    <br>

    <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert alert-success text-center">
            <?= session()->getFlashdata('msg') ?>
        </div>
    <?php endif; ?>

    <?php if (empty($consultas)): ?>
        <div class="text-center p-5">
            <h4 class="text-muted">No hay consultas pendientes de respuesta.</h4>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-light table-striped table-hover mt-3 border">
                <thead>
                    <tr style="color: #1D94AC;">
                        <th>Fecha</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Asunto</th>
                        <th>Mensaje</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($consultas as $con): ?>
                        <tr>
                            <td><?= isset($con['fecha']) ? date('d/m/Y H:i', strtotime($con['fecha'])) : '---'; ?></td>
                            <td><?= $con['nombre']; ?></td>
                            <td><?= $con['email']; ?></td>
                            <td><?= $con['asunto'] ?? 'Sin asunto'; ?></td>
                            <td>
                                <?= (strlen($con['mensaje']) > 50) ? substr($con['mensaje'], 0, 50) . '...' : $con['mensaje']; ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?= base_url('detalle-consulta/'.$con['id']); ?>" class="btn btn-sm btn-outline-info">Ver Todo</a>
                                    
                                    <a href="<?= base_url('resolver-consulta/'.$con['id']); ?>" 
                                       class="btn btn-sm btn-outline-success" 
                                       onclick="return confirm('¿Marcar esta consulta como resuelta?')">
                                       <i class="bi bi-check-circle"></i> Resolver
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    
    <div class="text-center mt-3">
        <a href="<?= base_url('consultasResueltas'); ?>" class="btn btn-secondary">Ver Consultas Resueltas</a>
    </div>
</div>