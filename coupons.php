<?php
/* =========================================================================
   CupomIA — Gerador + Atualizador de Cupons (PHP, sem UI)
   --------------------------------------------------------------------------
   Funciona sozinho: gera cupons realistas, salva no Bolt Database e atualiza
   continuamente (novos cupons + limpeza de expirados).


   Requisitos: PHP 7.4+ com cURL habilitado.


   Como usar:
     php coupons.php                  # roda o loop infinito
     php coupons.php --once           # gera um lote e sai
     php coupons.php --count 20       # define quantos cupons por lote (padrão: 8)
   ========================================================================= */


// ====================== CONFIGURAÇÃO ======================
$SUPABASE_URL = "https://axeymfffugrlhvrejjca.supabase.co";
$SUPABASE_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImF4ZXltZmZmdWdybGh2cmVqamNhIiwicm9sZSI6ImFub24iLCJpYXQiOjE3ODUzNDEwNzYsImV4cCI6MjEwMDkxNzA3Nn0.itgvJhiXptaDSv-d782EbOIOrGow3eNFFwQV8tZ87Yo";


// Intervalos do loop (em segundos)
$POLL_SEC = 60;        // a cada 60s: limpa expirados, marca antigos
$GENERATE_SEC = 180;   // a cada 3min: gera novos cupons
$DEFAULT_COUNT = 8;    // cupons por lote
// ==========================================================


$REST = "$SUPABASE_URL/rest/v1/coupons";


// ---------- Pools de dados ----------
$STORES = [
  "Amazon", "Magazine Luiza", "Shopee", "AliExpress", "Mercado Livre",
  "Kabum", "Casas Bahia", "Netshoes", "Centauro", "Pichau",
];


$PRODUCTS = [
  "Eletrônicos" => [
    ["t" => "Smartphone Galaxy A55 128GB", "min" => 1200, "max" => 2200],
    ["t" => 'Smart TV 50" 4K UHD', "min" => 1800, "max" => 3200],
    ["t" => "Notebook Gamer RTX 4060 16GB", "min" => 4500, "max" => 7500],
    ["t" => "Fone Bluetooth JBL Tune 770NC", "min" => 350, "max" => 700],
    ["t" => "Caixa de Som Portátil Bluetooth", "min" => 150, "max" => 450],
    ["t" => "Tablet Samsung Galaxy Tab S9", "min" => 2800, "max" => 4800],
    ["t" => "Console PlayStation 5 Slim", "min" => 3000, "max" => 4200],
    ["t" => "Smartwatch Amazfit GTR 4", "min" => 600, "max" => 1200],
  ],
  "Moda" => [
    ["t" => "Tênis Nike Air Max 90", "min" => 400, "max" => 800],
    ["t" => "Camiseta Polo Masculina 3pk", "min" => 80, "max" => 180],
    ["t" => "Jaqueta Jeans Feminina", "min" => 150, "max" => 350],
    ["t" => "Bolsa Tote Couro Sintético", "min" => 90, "max" => 250],
    ["t" => "Óculos de Sol Aviador", "min" => 60, "max" => 200],
    ["t" => "Relógio Masculino Aço Inox", "min" => 120, "max" => 400],
  ],
  "Casa & Decoração" => [
    ["t" => "Aspirador Robô Wi-Fi", "min" => 600, "max" => 1800],
    ["t" => "Conjunto de Panelas Antiaderente 7pc", "min" => 200, "max" => 500],
    ["t" => "Cafeteira Espresso Automática", "min" => 800, "max" => 2500],
    ["t" => "Luminária de Mesa LED Touch", "min" => 80, "max" => 220],
    ["t" => "Tapete Decorativo 2x3m", "min" => 150, "max" => 600],
    ["t" => "Organizador de Closet Modular", "min" => 200, "max" => 500],
  ],
  "Esportes" => [
    ["t" => "Bicicleta Aro 29 21 Marchas", "min" => 1200, "max" => 2800],
    ["t" => "Suplemento Whey Protein 1kg", "min" => 90, "max" => 200],
    ["t" => "Kit Halteres 20kg Ajustável", "min" => 250, "max" => 600],
    ["t" => "Esteira Elétrica Dobrável", "min" => 1500, "max" => 4000],
    ["t" => "Raquete de Tênis Profissional", "min" => 300, "max" => 900],
    ["t" => "Jaqueta Corta Vento Esportiva", "min" => 80, "max" => 250],
  ],
  "Beleza" => [
    ["t" => "Kit Skincare Vitamina C 4pc", "min" => 120, "max" => 350],
    ["t" => "Secador de Cabelo Profissional 2200W", "min" => 150, "max" => 450],
    ["t" => "Perfume Importado 100ml", "min" => 180, "max" => 500],
    ["t" => "Prancha Alisadora Cerâmica", "min" => 100, "max" => 300],
    ["t" => "Hidratante Facial Anti-Idade", "min" => 80, "max" => 280],
  ],
  "Mercado" => [
    ["t" => "Cesta Básica Completa 30 itens", "min" => 180, "max" => 350],
    ["t" => "Café Torrado Premium 1kg", "min" => 35, "max" => 90],
    ["t" => "Cesta Churrasco + Bebidas", "min" => 120, "max" => 300],
    ["t" => "Leite Integral 12 Litros", "min" => 40, "max" => 80],
    ["t" => "Kit Limpeza 15 produtos", "min" => 50, "max" => 120],
  ],
  "Games" => [
    ["t" => "Jogo PS5 EA Sports FC 25", "min" => 200, "max" => 350],
    ["t" => "Controle Xbox Series X Sem Fio", "min" => 350, "max" => 550],
    ["t" => "Cadeira Gamer Reclinável", "min" => 600, "max" => 1500],
    ["t" => "Teclado Mecânico RGB ABNT2", "min" => 200, "max" => 500],
    ["t" => "Mouse Gamer 16000 DPI", "min" => 120, "max" => 400],
    ["t" => "Headset Surround 7.1", "min" => 180, "max" => 500],
  ],
  "Viagens" => [
    ["t" => "Pacote Buenos Aires 5 dias All Inclusive", "min" => 2500, "max" => 5000],
    ["t" => "Resort All Inclusive 3 noites casal", "min" => 1500, "max" => 3500],
    ["t" => "Passagem Aérea Rio-São Paulo", "min" => 300, "max" => 700],
    ["t" => "Hotel 4 estrelas Gramado 2 diárias", "min" => 500, "max" => 1200],
    ["t" => "Cruzeiro Marítimo 7 noites", "min" => 2000, "max" => 4500],
  ],
];


$CATEGORIES = array_keys($PRODUCTS);


// ---------- Helpers ----------
function rnd($min, $max) { return rand($min, $max); }
function pick($arr) { return $arr[array_rand($arr)]; }
function round2($n) { return round($n, 2); }


function genCouponCode($store) {
  $prefix = strtoupper(substr(strtok($store, " "), 0, 4));
  $suffix = strtoupper(substr(bin2hex(random_bytes(4)), 0, 5));
  return $prefix . $suffix;
}


// ---------- Gerador ----------
function generateCoupon() {
  global $PRODUCTS, $CATEGORIES, $STORES;
  $category = pick($CATEGORIES);
  $product = pick($PRODUCTS[$category]);
  $store = pick($STORES);


  $original = round2(rnd($product["min"] * 100, $product["max"] * 100) / 100);
  $discount = rnd(10, 80);
  $discounted = round2($original * (1 - $discount / 100));
  $hasCode = (rand(1, 10) > 4);
  $isHot = (rand(1, 100) <= 15);
  $daysToExpire = rnd(1, 14);
  $expiresAt = gmdate("Y-m-d\TH:i:s\Z", time() + $daysToExpire * 86400);
  $seed = substr(bin2hex(random_bytes(5)), 0, 8);


  return [
    "title" => $product["t"],
    "description" => "$discount% OFF em " . $product["t"] . " — oferta por tempo limitado na $store.",
    "store" => $store,
    "category" => $category,
    "image_url" => "https://picsum.photos/seed/$seed/400/300",
    "original_price" => $original,
    "discounted_price" => $discounted,
    "discount_percentage" => $discount,
    "coupon_code" => $hasCode ? genCouponCode($store) : null,
    "external_url" => "https://www.google.com/search?q=" . urlencode($product["t"] . " " . $store),
    "is_hot" => $isHot,
    "is_new" => true,
    "expires_at" => $expiresAt,
  ];
}


// ---------- Bolt Database cURL ----------
function supabaseRequest($url, $method, $body = null) {
  global $SUPABASE_KEY;
  $ch = curl_init($url);
  $headers = [
    "apikey: $SUPABASE_KEY",
    "Authorization: Bearer $SUPABASE_KEY",
    "Content-Type: application/json",
  ];
  if ($body !== null) $headers[] = "Prefer: return=representation";
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => $method,
    CURLOPT_POSTFIELDS => $body,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_TIMEOUT => 30,
  ]);
  $res = curl_exec($ch);
  $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  if ($code >= 400) throw new Exception("HTTP $code: $res");
  return json_decode($res, true);
}


function insertCoupons($coupons) {
  global $REST;
  return supabaseRequest($REST, "POST", json_encode($coupons));
}


function deleteExpired() {
  global $REST, $SUPABASE_KEY;
  $nowIso = gmdate("Y-m-d\TH:i:s\Z");
  $url = $REST . "?expires_at=lt." . urlencode($nowIso);
  $ch = curl_init($url);
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "DELETE",
    CURLOPT_HTTPHEADER => [
      "apikey: $SUPABASE_KEY",
      "Authorization: Bearer $SUPABASE_KEY",
      "Prefer: return=representation",
    ],
    CURLOPT_TIMEOUT => 30,
  ]);
  $res = curl_exec($ch);
  curl_close($ch);
  $deleted = json_decode($res, true);
  return is_array($deleted) ? count($deleted) : 0;
}


function markOldAsNotNew() {
  global $REST, $SUPABASE_KEY;
  $cutoff = gmdate("Y-m-d\TH:i:s\Z", time() - 86400);
  $url = $REST . "?is_new=eq.true&created_at=lt." . urlencode($cutoff);
  $ch = curl_init($url);
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "PATCH",
    CURLOPT_POSTFIELDS => json_encode(["is_new" => false]),
    CURLOPT_HTTPHEADER => [
      "apikey: $SUPABASE_KEY",
      "Authorization: Bearer $SUPABASE_KEY",
      "Content-Type: application/json",
      "Prefer: return=minimal",
    ],
    CURLOPT_TIMEOUT => 30,
  ]);
  curl_exec($ch);
  curl_close($ch);
}


function fetchStats() {
  global $REST, $SUPABASE_KEY;
  $url = $REST . "?select=*&order=created_at.desc&limit=1000";
  $ch = curl_init($url);
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
      "apikey: $SUPABASE_KEY",
      "Authorization: Bearer $SUPABASE_KEY",
    ],
    CURLOPT_TIMEOUT => 30,
  ]);
  $res = curl_exec($ch);
  curl_close($ch);
  $all = json_decode($res, true) ?: [];
  $now = time();
  $active = 0; $todayCount = 0; $hot = 0; $stores = [];
  $todayStart = strtotime("today");
  foreach ($all as $c) {
    if (strtotime($c["expires_at"]) > $now) $active++;
    if (strtotime($c["created_at"]) >= $todayStart) $todayCount++;
    if (!empty($c["is_hot"])) $hot++;
    $stores[$c["store"]] = true;
  }
  return [
    "active_coupons" => $active,
    "added_today" => $todayCount,
    "hot_deals" => $hot,
    "stores_count" => count($stores),
  ];
}


// ---------- Loop ----------
function generateBatch($count) {
  $batch = [];
  for ($i = 0; $i < $count; $i++) $batch[] = generateCoupon();
  $inserted = insertCoupons($batch);
  echo "✅ " . count($inserted) . " cupons gerados e salvos\n";
  return $inserted;
}


function pollCycle() {
  try {
    $removed = deleteExpired();
    if ($removed > 0) echo "🗑️ $removed cupons expirados removidos\n";
    markOldAsNotNew();
    $stats = fetchStats();
    echo "📊 Ativos: {$stats['active_coupons']} | Hoje: {$stats['added_today']} | Hot: {$stats['hot_deals']} | Lojas: {$stats['stores_count']}\n";
  } catch (Exception $e) {
    echo "❌ pollCycle: " . $e->getMessage() . "\n";
  }
}


function startAutoUpdate($count) {
  echo "🚀 CupomIA iniciado — gerando e atualizando cupons continuamente\n\n";
  generateBatch($count);
  pollCycle();


  while (true) {
    generateBatch($count);
    sleep($GLOBALS['GENERATE_SEC']);
    pollCycle();
    sleep($GLOBALS['POLL_SEC']);
  }
}


// ---------- CLI ----------
$opts = getopt("", ["once", "count::"]);
$once = isset($opts["once"]);
$count = isset($opts["count"]) ? intval($opts["count"]) : $DEFAULT_COUNT;


if ($once) {
  echo "Gerando um lote único...\n";
  generateBatch($count);
  pollCycle();
  exit(0);
} else {
  startAutoUpdate($count);
}





