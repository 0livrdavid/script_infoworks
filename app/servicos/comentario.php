<div class="container">
  <div class="row mt-3">
    <div class="col-1">
      <img src="../../files/<?php echo $image["imagem_tudo"]['filepath'] ?>" class="img-thumbnail" alt="User's Profile Picture">
    </div>
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title"><?php echo $obj['nome'] ?> - <span style="color: #8e98a2; font-size: 0.9rem;"><?php echo tempoPassado($obj['created_at']) ?></span></h6>
          <p class="card-text" style="color: #4b5158;"><?php echo $obj['comentario'] ?></p>
        </div>
      </div>
    </div>
  </div>
</div>
