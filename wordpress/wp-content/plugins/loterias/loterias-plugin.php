<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

class LoteriasPlugin {
    public function __construct() {
        add_action( 'init', [ $this, 'register_post_type' ] );
        add_shortcode( 'loteria_resultado', [ $this, 'render_shortcode' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
    }

    public function enqueue_styles() {
        wp_enqueue_style( 'loterias-style', plugin_dir_url( __FILE__ ) . 'css/loterias.css' );
    }

    public function register_post_type() {
        register_post_type( 'loterias', [
            'labels' => [
                'name' => 'Loterias',
                'singular_name' => 'Loteria',
            ],
            'public' => true,
            'has_archive' => true,
            'supports' => ['title', 'editor'],
        ]);
    }

    public function render_shortcode( $atts ) {
        $atts = shortcode_atts( [
            'loteria' => '',
            'concurso' => 'latest',
        ], $atts, 'loteria_resultado' );

        $loteria = sanitize_text_field( $atts['loteria'] );
        $concurso = sanitize_text_field( $atts['concurso'] );

        if ( empty( $loteria ) ) {
            return 'Digite o nome da loteria';
        }

        $results = $this->get_lottery_results( $loteria, $concurso );
        return $this->format_results( $results );
    }

    private function get_lottery_results( $loteria, $concurso ) {
        $post_id = $this->get_post_id_by_concurso( $loteria, $concurso );
        if ( $post_id ) {
            return get_post( $post_id );
        }

        $api_url = "https://loterias-api-url.com/$loteria/$concurso";
        $response = wp_remote_get( $api_url );

        if ( is_wp_error( $response ) ) {
            return 'Erro ao consultar';
        }

        $data = json_decode( wp_remote_retrieve_body( $response ), true );
        if ( ! isset( $data['resultado'] ) ) {
            return 'Não encontrado.';
        }

        $this->save_results( $loteria, $data['resultado'], $concurso );
        return $data['resultado'];
    }

    private function save_results( $loteria, $resultado, $concurso ) {
        $post_data = [
            'post_title'   => "{$loteria} - Concurso $concurso",
            'post_content' => json_encode( $resultado ),
            'post_type'    => 'loterias',
            'post_status'  => 'publish',
        ];

        wp_insert_post( $post_data );
    }

    private function get_post_id_by_concurso( $loteria, $concurso ) {
        $args = [
            'post_type' => 'loterias',
            'meta_query' => [
                [
                    'key'   => 'concurso',
                    'value' => $concurso,
                ],
            ],
            'posts_per_page' => 1,
        ];

        $query = new WP_Query( $args );
        return $query->have_posts() ? $query->posts[0]->ID : false;
    }

    private function format_results( $results ) {
        //layout figma
        ob_start();
        ?>
        <header>
        <h2>Concurso <?php $results['concurso'] ?> * <?php $results['data'] ?></h2>
    </header>

    <main>
        <div class="bolas">
        <?php
            $dezenas = $results['dezenas'];
            $quantidadeDezena = count($dezenas);
            for ($i = 0; $i < $quantidadeDezena; $i++) {
                echo '<div class="bola">'.$dezenas[$i].'</div>';
            }
        ?>
        </div>
        <hr>
            <h1 class="titulo-premio">
                PRÊMIO<br>
                <?php "R$ ". number_format($results['valorArrecadado'], 2, ',', '.') ?>
            </h1>
        <hr>

        <table>
            <thead>
                <tr>
                    <th>Faixas</th>
                    <th>Ganhadores</th>
                    <th>Prêmio</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $ganhadores = $results['ganhadores'];
                    for ($i = 0; $i < count($ganhadores); $i++) {
                        echo "<tr>";
                        if($ganhadores[$i]['faixa'] == 1){
                            $faixa = "<td>Sena</td>";
                        } else if($ganhadores[$i]['faixa'] == 2){
                            $faixa = "<td>Quina</td>";
                        } else {
                            $faixa = "<td>Quadra</td>";
                        }
                        echo $faixa;
                        echo "<td>" . $ganhadores[$i]['ganhadores'] . "</td>";
                        echo "<td>R$ " . number_format($ganhadores[$i]['valorPremio'], 2, ',', '.') . "</td>";
                        echo "</tr>";
                    }
                ?>
                <!-- <tr>
                    <td>Sena</td>
                    <td></td>
                    <td>R$ 1.000,00</td>
                </tr>
                <tr>
                    <td>Quina</td>
                    <td>5</td>
                    <td>R$ 500,00</td>
                </tr>
                <tr>
                    <td>Quadra</td>
                    <td>2</td>
                    <td>R$ 250,00</td>
                </tr> -->
            </tbody>
        </table>
    </main>
        <?php
        return ob_get_clean();
    }
}

new LoteriasPlugin();
