<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Sélection de siège - CoVilla</title>
    <meta name="viewport" content="width=device-width, initial-scale=0.42">
    <link rel="stylesheet" href="views/assets/css/global.css">
    <link rel="stylesheet" href="views/assets/css/styleguide.css">
    <link rel="stylesheet" href="views/assets/css/style.css">
    <link rel="stylesheet" href="views/assets/css/seat_selection_view.css">
    <script src="views/assets/js/seat_selection_view.js"></script>
    <style>
</style>
</head>
<body>
    <form id="seatForm" action="process_seat" method="post">
        <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
        <input type="hidden" id="seat_id" name="seat_id">
    </form>
    <div id="customAlert"></div>

<div class="desktop">
      <div class="overlap">
        <div class="rectangle"></div>
        <?php echo dynamicSeat('ellipse', 'b19', $seats); ?>
        <div class="div"></div>
        <?php echo dynamicSeat('div', 'b20', $seats); ?>
        <?php echo dynamicSeat('ellipse-2', 'b21', $seats); ?>
        <?php echo dynamicSeat('ellipse-3', 'b22', $seats); ?>

        <img class="dfe-d" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-39.png" />
        <img class="img" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-40.png" />
        <img class="dfe-d-2" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-41.png" />
        <img class="dfe-d-3" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-42.png" />
      </div>
      <div class="overlap-group">
        <div class="overlap-2">
          <div class="rectangle"></div>
          <?php echo dynamicSeat('ellipse-2', 'e6', $seats); ?>
          <?php echo dynamicSeat('ellipse-3', 'e5', $seats); ?>
          <img class="dfe-d-2" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-111.png" />
          <img class="dfe-d-3" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-112.png" />
          <div class="rectangle-2"></div>
          <div class="rectangle-2"></div>
          <div class="rectangle-3"></div>
        </div>
        <div class="overlap-3">
          <?php echo dynamicSeat('ellipse-4', 'e7', $seats); ?>
          <img class="dfe-d-4" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-114.png" />
          <?php echo dynamicSeat('ellipse-4', 'B4', $seats); ?>
          <img class="dfe-d-4" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-118.png" />
        </div>
        <div class="overlap-4">
          <?php echo dynamicSeat('ellipse-4', 'e8', $seats); ?>
          <img class="dfe-d-4" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-113.png" />
          <?php echo dynamicSeat('ellipse-4', 'B6', $seats); ?>
          <img class="dfe-d-4" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-117.png" />
        </div>
        <div class="overlap-5">
          <?php echo dynamicSeat('ellipse-4', 'e4', $seats); ?>
          <img class="dfe-d-4" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-115.png" />
          <?php echo dynamicSeat('ellipse-4', 'B8', $seats); ?>
          <img class="dfe-d-4" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-119.png" />
        </div>
        <div class="overlap-6">
          <?php echo dynamicSeat('ellipse-4', 'e3', $seats); ?>
          <img class="dfe-d-4" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-116.png" />
          <?php echo dynamicSeat('ellipse-4', 'B10', $seats); ?>
          <img class="dfe-d-4" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-120.png" />
        </div>
        <div class="overlap-7">
          <?php echo dynamicSeat('ellipse-4', 'e9', $seats); ?>
          <img class="dfe-d-4" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-122.png" />
        </div>
        <div class="overlap-8">
          <?php echo dynamicSeat('ellipse-4', 'e10', $seats); ?>
          <img class="dfe-d-4" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-121.png" />
        </div>
        <div class="overlap-9">
          <?php echo dynamicSeat('ellipse-4', 'e2', $seats); ?>
          <img class="dfe-d-4" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-123.png" />
        </div>
        <div class="overlap-10">
          <?php echo dynamicSeat('ellipse-4', 'e1', $seats); ?>
          <img class="dfe-d-4" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-124.png" />
        </div>
      </div>
      <div class="overlap-11">
        <div class="rectangle-4"></div>
        <div class="overlap-12">
          <div class="rectangle-5"></div>
          <?php echo dynamicSeat('ellipse-5', 'C1', $seats); ?>
          <?php echo dynamicSeat('ellipse-6', 'C2', $seats); ?>
          <?php echo dynamicSeat('ellipse-7', 'C3', $seats); ?>
          <?php echo dynamicSeat('ellipse-8', 'C4', $seats); ?>
          <img class="dfe-d-5" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-127.png" />
          <img class="dfe-d-6" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-128.png" />
          <img class="dfe-d-7" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-129.png" />
          <img class="dfe-d-8" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-130.png" />
          <div class="rectangle-5"></div>
          <?php echo dynamicSeat('ellipse-5', 'C5', $seats); ?>
          <?php echo dynamicSeat('ellipse-6', 'C6', $seats); ?>
          <?php echo dynamicSeat('ellipse-7', 'C7', $seats); ?>
          <?php echo dynamicSeat('ellipse-8', 'C8', $seats); ?>
          <img class="dfe-d-5" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-131.png" />
          <img class="dfe-d-6" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-132.png" />
          <img class="dfe-d-7" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-133.png" />
          <img class="dfe-d-8" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-134.png" />
          <?php echo dynamicSeat('ellipse-6', 'C9', $seats); ?>
        </div>
        <div class="overlap-13">
          <div class="rectangle-5"></div>
          <?php echo dynamicSeat('ellipse-5', 'C10', $seats); ?>
          <?php echo dynamicSeat('ellipse-6', 'C11', $seats); ?>
          <?php echo dynamicSeat('ellipse-7', 'C12', $seats); ?>
          <?php echo dynamicSeat('ellipse-8', 'C13', $seats); ?>
          <img class="dfe-d-5" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-135.png" />
          <img class="dfe-d-6" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-136.png" />
          <img class="dfe-d-7" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-137.png" />
          <img class="dfe-d-8" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-138.png" />
        </div>
      </div>
      <div class="overlap-14">
        <?php echo dynamicSeat('ellipse-9', 'D1', $seats); ?>
        <img class="dfe-d-4" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-125.png" />
      </div>
      <div class="overlap-15">
        <?php echo dynamicSeat('ellipse-9', 'D2', $seats); ?>
        <img class="dfe-d-4" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-126.png" />
      </div>
      <div class="overlap-16">
        <?php echo dynamicSeat('ellipse-10', 'c2', $seats); ?>
        <img class="dfe-d-9" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-48.png" />
        <?php echo dynamicSeat('ellipse-10', 'D4', $seats); ?>
        <img class="dfe-d-9" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-104.png" />
      </div>
      <div class="overlap-17">
        <?php echo dynamicSeat('ellipse-10', 'c1', $seats); ?>
        <img class="dfe-d-9" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-47.png" />
        <?php echo dynamicSeat('ellipse-10', 'D6', $seats); ?>
        <img class="dfe-d-9" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-103.png" />
      </div>
      <div class="overlap-18">
        <?php echo dynamicSeat('ellipse-10', 'c4', $seats); ?>
        <img class="dfe-d-9" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-72.png" />
        <?php echo dynamicSeat('ellipse-10', 'D8', $seats); ?>
        <img class="dfe-d-9" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-106.png" />
      </div>
      <div class="overlap-19">
        <?php echo dynamicSeat('ellipse-10', 'c3', $seats); ?>
        <img class="dfe-d-9" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-71.png" />
        <?php echo dynamicSeat('ellipse-10', 'D10', $seats); ?>
        <img class="dfe-d-9" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-105.png" />
      </div>
      <div class="group">
        <div class="rectangle-6"></div>
        <div class="overlap-group-2">
          <div class="rectangle-7"></div>
          <div class="rectangle-8"></div>
        </div>
      </div>
      <div class="overlap-20">
        <?php echo dynamicSeat('ellipse-10', 'c6', $seats); ?>
        <img class="dfe-d-9" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-74.png" />
        <?php echo dynamicSeat('ellipse-10', 'D12', $seats); ?>
        <img class="dfe-d-9" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-108.png" />
      </div>
      <div class="overlap-21">
        <?php echo dynamicSeat('ellipse-10', 'c5', $seats); ?>
        <img class="dfe-d-9" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-73.png" />
        <?php echo dynamicSeat('ellipse-10', 'D14', $seats); ?>
        <img class="dfe-d-9" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-107.png" />
      </div>
      <div class="overlap-22">
        <div class="overlap-23">
          <div class="rectangle-9"></div>
          <?php echo dynamicSeat('ellipse-11', 'c8', $seats); ?>
          <?php echo dynamicSeat('ellipse-12', 'c7', $seats); ?>
          <img class="dfe-d-10" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-75.png" />
          <img class="dfe-d-11" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-76.png" />
          <?php echo dynamicSeat('ellipse-13', 'E3', $seats); ?>
          <?php echo dynamicSeat('ellipse-14', 'E4', $seats); ?>
        </div>
        <div class="overlap-24">
          <div class="rectangle-9"></div>
          <?php echo dynamicSeat('ellipse-11', 'c10', $seats); ?>
          <?php echo dynamicSeat('ellipse-12', 'c9', $seats); ?>
          <img class="dfe-d-10" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-77.png" />
          <img class="dfe-d-11" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-78.png" />
          <?php echo dynamicSeat('ellipse-13', '', $seats); ?>
          <?php echo dynamicSeat('ellipse-14', 'E8', $seats); ?>
        </div>
        <div class="overlap-25">
          <div class="rectangle-9"></div>
          <?php echo dynamicSeat('ellipse-11', 'E9', $seats); ?>
          <?php echo dynamicSeat('ellipse-12', 'E10', $seats); ?>
          <?php echo dynamicSeat('ellipse-13', 'c11', $seats); ?>
          <?php echo dynamicSeat('ellipse-14', 'c12', $seats); ?>
          <img class="dfe-d-14" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-81.png" />
          <img class="dfe-d-13" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-82.png" />
        </div>
      </div>
      <div class="overlap-26">
        <?php echo dynamicSeat('ellipse-15', 'A1', $seats); ?>
        <?php echo dynamicSeat('ellipse-16', 'A2', $seats); ?>
        <img class="dfe-d-15" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-65.png" />
        <img class="dfe-d-16" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-66.png" />
        <?php echo dynamicSeat('ellipse-17', 'A3', $seats); ?>
        <img class="dfe-d-17" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-68.png" />
        <?php echo dynamicSeat('ellipse-18', 'A4', $seats); ?>
        <?php echo dynamicSeat('ellipse-19', 'A5', $seats); ?>
        <img class="dfe-d-18" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-69.png" />
        <img class="dfe-d-19" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-70.png" />
        <img class="rectangle-10" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/rectangle-43.svg" />
        <img class="rectangle-11" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/rectangle-45.svg" />
        <img class="rectangle-12" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/rectangle-45.svg" />
        <img class="rectangle-13" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/rectangle-43.svg" />
        <img class="rectangle-14" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/rectangle-46.svg" />
      </div>
      <div class="overlap-27">
        <div class="rectangle-15"></div>
        <?php echo dynamicSeat('ellipse-20', 'b1', $seats); ?>
        <?php echo dynamicSeat('ellipse-21', 'b2', $seats); ?>
        <img class="dfe-d-20" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-63.png" />
        <img class="dfe-d-21" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-64.png" />
        <img class="cfa-f" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/c67f404a-3754-46f5-b3c2-dcc8eb6e70db-1.png" />
      </div>
      <div class="overlap-28">
        <div class="rectangle-16"></div>
        <?php echo dynamicSeat('ellipse-22', 'b7', $seats); ?>
        <?php echo dynamicSeat('ellipse-23', 'F4', $seats); ?>
        <?php echo dynamicSeat('ellipse-24', 'F5', $seats); ?>
        <?php echo dynamicSeat('ellipse-25', 'F6', $seats); ?>
        <img class="dfe-d-22" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-51.png" />
        <img class="dfe-d-23" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-52.png" />
        <img class="dfe-d-24" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-53.png" />
        <img class="dfe-d-25" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-54.png" />
        <div class="rectangle-16"></div>
        <?php echo dynamicSeat('ellipse-22', 'b15', $seats); ?>
        <?php echo dynamicSeat('ellipse-23', 'b16', $seats); ?>
        <?php echo dynamicSeat('ellipse-24', 'b17', $seats); ?>
        <?php echo dynamicSeat('ellipse-25', 'b18', $seats); ?>
        <img class="dfe-d-22" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-87.png" />
        <img class="dfe-d-23" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-88.png" />
        <img class="dfe-d-24" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-89.png" />
        <img class="dfe-d-25" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-90.png" />
      </div>
      <div class="overlap-29">
        <div class="rectangle-16"></div>
        <?php echo dynamicSeat('ellipse-22', 'b11', $seats); ?>
        <?php echo dynamicSeat('ellipse-23', 'b12', $seats); ?>
        <?php echo dynamicSeat('ellipse-24', 'b13', $seats); ?>
        <?php echo dynamicSeat('ellipse-25', 'b14', $seats); ?>
        <img class="dfe-d-22" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-91.png" />
        <img class="dfe-d-23" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-92.png" />
        <img class="dfe-d-24" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-93.png" />
        <img class="dfe-d-25" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-94.png" />
      </div>
      <div class="overlap-30">
        <div class="rectangle-16"></div>
        <?php echo dynamicSeat('ellipse-22', 'b7', $seats); ?>
        <?php echo dynamicSeat('ellipse-23', 'b8', $seats); ?>
        <?php echo dynamicSeat('ellipse-24', 'b9', $seats); ?>
        <?php echo dynamicSeat('ellipse-25', 'b10', $seats); ?>
        <img class="dfe-d-22" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-95.png" />
        <img class="dfe-d-23" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-96.png" />
        <img class="dfe-d-24" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-97.png" />
        <img class="dfe-d-25" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-98.png" />
      </div>
      <div class="overlap-31">
        <div class="overlap-32">
          <div class="rectangle-16"></div>
          <?php echo dynamicSeat('ellipse-22', 'b3', $seats); ?>
          <?php echo dynamicSeat('ellipse-24', 'b5', $seats); ?>
          <img class="dfe-d-23" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-100.png" />
          <img class="dfe-d-24" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-101.png" />
        </div>
        <div class="overlap-33">
          <?php echo dynamicSeat('ellipse-26', 'b4', $seats); ?>
          <img class="dfe-d-26" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-99.png" />
        </div>
        <div class="overlap-34">
          <?php echo dynamicSeat('ellipse-26', 'b6', $seats); ?>
          <img class="dfe-d-27" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/d2f8126e-5745-43d2-99e3-31d359f264d9-102.png" />
        </div>
      </div>
      <button class="button">
        <div class="state-layer"><div class="label-text">Premier étage</div></div>
      </button>
      <button class="state-layer-wrapper">
        <div class="state-layer"><div class="text-wrapper">Rez-de-chaussée</div></div>
      </button>
      <div class="overlap-wrapper">
        <div class="overlap-35">
          <img class="rectangle-17" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/rectangle-48.svg" />
          <div class="text-wrapper-2">Hommes</div>
        </div>
      </div>
      <div class="overlap-group-wrapper">
        <div class="overlap-36">
          <img class="rectangle-18" src="https://c.animaapp.com/m8c813hiC6i6OZ/img/rectangle-48.svg" />
          <div class="text-wrapper-3">Femmes</div>
        </div>
      </div>
    </div>
  </body>
</html>
