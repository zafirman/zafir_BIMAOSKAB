<?php 


/**
 * 
 */
class Rptwo_m extends Bismillah_Model
{
	
    public function loadgrid($va){
        $limit    = $va['offset'].",".$va['limit'] ;
        $search	  = isset($va['search'][0]['value']) ? $va['search'][0]['value'] : "" ;
        $search   = $this->escape_like_str($search) ;
        $field    = "m.*,IFNULL(m.StartDateTime,'-') AS TglProses, IFNULL(MAX(f.EndDateTime),'-') AS TglStatusAkhir";
        $where 	  = array() ; 
        $where[]    = "m.Status <> 'D'";
        if($search !== "") $where[]	= "(m.Kode LIKE '{$search}%' OR m.Deskripsi LIKE '%{$search}%')" ;
        $where 	  = implode(" AND ", $where) ;
        $join     = "left join work_order_form f on f.Kode=m.Kode";
        $dbd      = $this->select("work_order_master m", $field, $where, $join, "m.Kode", "m.Kode DESC", $limit) ;
        $dba      = $this->select("work_order_master m", "m.ID", $where, $join, "m.Kode") ;

        return array("db"=>$dbd, "rows"=> $this->rows($dba) ) ;
    }

    public function getDetailFormWO($cKode)
    {
        $field = "*";
        $where = "Kode = '$cKode'";
        $dbd   = $this->select("work_order_form", $field, $where, "Faktur","Faktur ASC") ;
        return $dbd ;
    }
    public function getFileFormWO($cFaktur){
        $field = "*";
        $where = "Faktur = '$cFaktur'";
        $dbd   = $this->select("work_order_form_file", $field, $where) ;
        return $dbd;
    }

}

?>