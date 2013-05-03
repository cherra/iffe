<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Jpgraph
 *
 * @author cherra
 */
class Jpgraph {
    
    private $CI;
    private $graph_path;
    private $graph_url;
    private $graph_file;
    private $graph_theme;
    
    function __construct() {
        require_once("jpgraph/jpgraph.php");
       
        $this->CI =& get_instance();
        $this->CI->load->library('encrypt');
        
        $this->graph_path = $this->CI->config->item('asset_path').$this->CI->config->item('graph_dir');
        $this->graph_url = asset_url().$this->CI->config->item('graph_dir');
        if(strlen($this->CI->config->item('graph_theme')) > 0){
            $tema = $this->CI->config->item('graph_theme');
        }else {
            $tema = "UniversalTheme";
        }
        $this->graph_theme = new $tema;
    }
    
    /*
     *  Función para dibujar un gráfico de linea
     * Parametros:
     * $ydata = arreglo con los valores
     * $titulo = Título del gráfico
     */
    function grafico_lineas($ydata, $ancho=350, $alto=250, $titulo='Gráfico de linea', $subtitulo='', $titulox='', $tituloy='')
    {
        require_once("jpgraph/jpgraph_line.php");    
        
        // Nombre de archivo aleatorio
        $this->graph_file = $this->CI->encrypt->sha1(rand()).'.png';
        
        // Se crea el objeto gráfico.
        $graph = new Graph($ancho,$alto,"auto",60);
        $graph->SetScale("textlin");
        $graph->SetTheme($this->graph_theme);
        
        // Títulos
        $graph->title->Set($titulo);
        $graph->subtitle->Set($subtitulo);
        $graph->xaxis->title->Set($titulox);
        $graph->yaxis->title->Set($tituloy);
        
        // Se plotea el gráfico de linea
        $plot=new LinePlot($ydata);
        $plot->SetColor("blue");
        
        // Se agrega al objecto graph
        $graph->Add($plot);
        
        // Se crea el gráfico y se escribe en un archivo
        $graph->Stroke('./'.$this->graph_path.$this->graph_file); 
        
        // Regresa el url de la imágen del gráfico
        return $this->graph_url.$this->graph_file;
    }
    
    function grafico_barras($ydata, $ancho=350, $alto=250, $titulo='Gráfico de barras', $subtitulo='', $titulox='', $tituloy='')
    {
        require_once("jpgraph/jpgraph_bar.php");    
        
        // Nombre de archivo aleatorio
        $this->graph_file = $this->CI->encrypt->sha1(rand()).'.png';
        
        // Se crea el objeto gráfico.
        $graph = new Graph($ancho,$alto,"auto",60);
        $graph->SetScale("textlin");
        $graph->SetTheme($this->graph_theme);
        
        // Títulos
        $graph->title->Set($titulo);
        $graph->subtitle->Set($subtitulo);
        $graph->xaxis->title->Set($titulox);
        $graph->yaxis->title->Set($tituloy);
        
        // Se plotea el gráfico de linea
        $plot=new BarPlot($ydata);
        $plot->SetFillColor("blue");
        
        // Se agrega al objecto graph
        $graph->Add($plot);
        
        // Se crea el gráfico y se escribe en un archivo
        $graph->Stroke('./'.$this->graph_path.$this->graph_file); 
        
        // Regresa el url de la imágen del gráfico
        return $this->graph_url.$this->graph_file;
    }
    
    function grafico_pastel($ydata, $ancho=350, $alto=250, $leyendas = null, $titulo='Gráfico de pastel', $subtitulo='')
    {
        require_once("jpgraph/jpgraph_pie.php");    
        
        // Nombre de archivo aleatorio
        $this->graph_file = $this->CI->encrypt->sha1(rand()).'.png';
        
        // Se crea el objeto gráfico.
        $graph = new PieGraph($ancho,$alto,"auto",60);
        $graph->SetScale("textlin");
        $graph->SetTheme($this->graph_theme);
        
        // Títulos
        $graph->title->Set($titulo);
        $graph->subtitle->Set($subtitulo);
        
        // Se plotea el gráfico de linea
        $plot=new PiePlot($ydata);
        if($leyendas){
            $plot->SetLegends($leyendas);
        }
        $plot->SetSize(0.3);
        $plot->SetGuideLines( true , true );
        
        // Se agrega al objecto graph
        $graph->Add($plot);
        
        // Se crea el gráfico y se escribe en un archivo
        $graph->Stroke('./'.$this->graph_path.$this->graph_file); 
        
        // Regresa el url de la imágen del gráfico
        return $this->graph_url.$this->graph_file;
    }
    
    function grafico_pastel_3d($data, $ancho=350, $alto=250, $leyendas = null, $titulo='Gráfico de pastel', $subtitulo='')
    {
        require_once("jpgraph/jpgraph_pie.php");    
        require_once("jpgraph/jpgraph_pie3d.php");    
        
        // Nombre de archivo aleatorio
        $this->graph_file = $this->CI->encrypt->sha1(rand()).'.png';
        
        // Se crea el objeto gráfico.
        $graph = new PieGraph($ancho,$alto,"auto",60);
        $graph->SetScale("textlin");
        $graph->SetTheme($this->graph_theme);
        
        // Títulos
        $graph->title->Set($titulo);
        $graph->subtitle->Set($subtitulo);
        
        // Se plotea el gráfico de linea
        $plot=new PiePlot3D($data);
        if($leyendas){
            $plot->SetLegends($leyendas);
        }
        $plot->SetSize(0.4);
        
        // Se agrega al objecto graph
        $graph->Add($plot);
        
        // Se crea el gráfico y se escribe en un archivo
        $graph->Stroke('./'.$this->graph_path.$this->graph_file); 
        
        // Regresa el url de la imágen del gráfico
        return $this->graph_url.$this->graph_file;
    }
    
    function grafico_gantt($data, $ancho=350, $alto=250, $titulo='Gráfico de Gantt', $subtitulo='')
    {
        //require_once("jpgraph/jpgraph_pie.php");    
        require_once("jpgraph/jpgraph_gantt.php");    
        
        // Nombre de archivo aleatorio
        $this->graph_file = $this->CI->encrypt->sha1(rand()).'.png';
        
//        // Se crea el objeto gráfico.
//        $graph = new GanttGraph($ancho,$alto,"auto",60);
//
//        // Títulos
//        $graph->title->Set($titulo);
//        $graph->subtitle->Set($subtitulo);
//
//        // Se agregan las actividades
//        // Demo
//        $plot=new GanttBar(0,"Firma de contrato","2013-04-05","2013-04-10");
//        $plot1=new GanttBar(1,"Autorizacion de credito","2013-04-11","2013-04-30");
//
//        // Se agrega al objecto graph
//        $graph->Add($plot);
//        $graph->Add($plot1);
//
//        // Se crea el gráfico y se escribe en un archivo
//        $graph->Stroke('./'.$this->graph_path.$this->graph_file); 
//
//        // Regresa el url de la imágen del gráfico
//        return $this->graph_url.$this->graph_file;
        
        $data = array(
            array(0,ACTYPE_GROUP, "CREDITO HIPOTECARIO BANAMEX","2013-04-22","2013-04-30",''),
            array(1,ACTYPE_NORMAL,"  Documentacion","2013-04-22","2013-04-22",''),
            array(2,ACTYPE_NORMAL,"  Firma de solicitud","2013-04-23","2013-04-25",''),
            array(3,ACTYPE_NORMAL,"  Autorizacion de credito","2013-04-26",'2013-04-30',''), 
            array(4,ACTYPE_GROUP,"INFONAVIT","2013-04-22","2013-05-10",''),
            array(5,ACTYPE_NORMAL,"  PASO 1","2013-04-20","2013-04-22",''),
            array(6,ACTYPE_NORMAL,"  PASO 2","2013-04-23","2013-04-24",''),
            array(7,ACTYPE_NORMAL,"  PASO 3","2013-04-25",'2013-04-30',''),
            array(8,ACTYPE_NORMAL,"  PASO 4","2013-04-25",'2013-05-05','') 
            );

        // The constrains between the activities
        $constrains = array(
            array(1,2,CONSTRAIN_ENDSTART),
            array(2,3,CONSTRAIN_ENDSTART),
            array(5,6,CONSTRAIN_ENDSTART),
            array(6,7,CONSTRAIN_ENDSTART),
            array(6,8,CONSTRAIN_ENDSTART)
        );

        $progress = array(
            array(1,1),
            array(2,1),
            array(5,1),
            array(6,1),
            array(7,0.2),
            array(8,0.3)
        );

        // Create the basic graph
        $alto=350;
        $ancho=950;
        $graph = new GanttGraph($ancho,$alto,"auto",60);
        $graph->title->Set("Escrituracion en transito: Carlos Maldonado");
        //$graph->SetFrame(false);

        // Setup scale
        $graph->ShowHeaders(GANTT_HYEAR | GANTT_HMONTH | GANTT_HDAY );
        //$graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAYWNBR);
        $graph->SetDateRange("2013-04-22", "2013-05-05");

        // Add the specified activities
        //$graph->SetSimpleStyle(GANTT_RDIAG, 'gray', 'blue');
        $graph->CreateSimple($data,$constrains,$progress);

        // .. and stroke the graph
        //$graph->Stroke();
        // Se crea el gráfico y se escribe en un archivo
        $graph->Stroke('./'.$this->graph_path.$this->graph_file); 
        
        // Regresa el url de la imágen del gráfico
        return $this->graph_url.$this->graph_file;
        
    }
    
}

?>
