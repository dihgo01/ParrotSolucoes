<?php

if (!isset($_SESSION)) {
    session_start();
}

date_default_timezone_set('Brazil/East');
include_once 'conexao.php';

class ClassesWeb {

    private $pdo;

    function get_query_unica($query) {
        $this->pdo = new Connection();
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }

    function get_query($query) {
        $this->pdo = new Connection();
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }

    function query_insert($campos, $parametros, $valores, $tabela) {
        $this->pdo = new Connection();
        $query = "INSERT INTO " . $tabela . " (" . $campos . ") VALUES (" . $parametros . ")";
        try {
            $stmt = $this->pdo->prepare($query, array("set names utf8"));
            $stmt->execute($valores);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function query_update($campos, $valores, $tabela, $where) {
        $this->pdo = new Connection();
        $query = "UPDATE " . $tabela . " SET " . $campos . " WHERE " . $where;
        try {
            $stmt = $this->pdo->prepare($query, array("set names utf8"));
            if ($stmt->execute($valores)) {
                return 1;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function query_delete($tabela, $id) {
        $this->pdo = new Connection();
        $query = "DELETE FROM " . $tabela . " WHERE id = " . $id;
        try {
            $stmt = $this->pdo->prepare($query, array("set names utf8"));
            if ($stmt->execute()) {
                return 1;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function query_delete_custom($tabela, $id) {
        $this->pdo = new Connection();
        $query = "DELETE FROM " . $tabela . " WHERE " . $id;
        try {
            $stmt = $this->pdo->prepare($query, array("set names utf8"));
            if ($stmt->execute()) {
                return 1;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
     * FUNÇÃO PARA VALIDAR O USUÁRIO NO LOGIN
     */

    function busca_usuario_login($email, $senha) {
        $this->pdo = new Connection();
        $query = "SELECT * FROM usuarios WHERE email = :email AND senha = :senha";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }

    /*
     * FUNÇÃO BUSCAR TODOS OS CLIENTES ERP ATIVOS OU BLOQUEADOS
     */

    function busca_clientes_erp() {
        $this->pdo = new Connection();
        $query = "SELECT *,(SELECT telefone FROM clientes_erp_tel LIMIT 1) AS cli_tel FROM clientes_erp WHERE status <> 'Inativo'";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }

    /*
     *  FUNÇÃO BUSCAR TODOS OS USUARIOS ERP ATIVOS OU BLOQUEADOS 
     */
    function busca_usuarios_erp() {
        $this->pdo = new Connection();
        $query = "SELECT * FROM usuarios WHERE status <> 'Inativo'";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch(PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }
    

    function busca_licencas() {
        $this->pdo = new Connection();
        $query = "SELECT * FROM licencas";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        } 
        return $result;
    }

    function busca_clientes() {
        $this->pdo = new Connection();
        $query = "SELECT * FROM clientes WHERE status <> 'Inativo'";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        } 
        return $result;
    }


    /*
     * FUNÇÃO BUSCAR TODOS OS Fornecedores ATIVOS OU BLOQUEADOS
     */


    function busca_fornecedores() {
        $this->pdo = new Connection();
        $query = "SELECT *,(SELECT telefone FROM fornecedores_telefone LIMIT 1) AS forn_tel FROM fornecedores WHERE status <> 'Inativo'";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }




     /*
     * FUNÇÃO BUSCAR TODOS OS Natureza Juridica
     */


    function busca_porte() {
        $this->pdo = new Connection();
        $query = "SELECT * FROM porte_empresa ORDER BY tipo ASC";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }
    /*
     * FUNÇÃO BUSCAR TODOS as Cidades
     */

    function busca_cidade() {
        $this->pdo = new Connection();
        $query = "SELECT * FROM cidades ORDER BY nome ASC";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }

    /**
     * BUSCA HIERARQUIA NA TABELA DE HIERARQUIAS 
     */
    function busca_hierarquia() {
        $this->pdo = new Connection();
        $query = "SELECT * FROM hierarquia ORDER BY id ASC";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }

    /**
     * BUSCA EMPRESA NA TABELA DE EMPRESAS 
     */
    function busca_empresa() {
        $this->pdo = new Connection();
        $query = "SELECT * FROM empresa ORDER BY id ASC";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }

    /**
     * BUSCA EMAIL NA TABELA DE USUARIOS  
     */
    function consulta_email($email, $tabela) {
        $this->pdo = new Connection();
        $query = "SELECT * FROM $tabela WHERE email = :email";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }

    /**
     * BUSCA EMAIL NA TABELA DE USUARIOS  
     */
    function consulta_email_clientes_erp($hash_email) {
        $this->pdo = new Connection();
        $query = "SELECT email FROM clientes_erp_email WHERE hash = " . $hash_email ."";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }

    function busca_pais() {
        $this->pdo = new Connection();
        $query = "SELECT * FROM paises ORDER BY nome ASC";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }
    /*
     * FUNÇÃO BUSCAR TODOS OS Estados 
     */


    function busca_estado() {
        $this->pdo = new Connection();
        $query = "SELECT * FROM estados ORDER BY nome ASC";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }

    /*
     * FUNÇÃO BUSCAR TODOS OS Natureza Juridica
     */


    function busca_nat_juridica() {
        $this->pdo = new Connection();
        $query = "SELECT * FROM naturezas_juridicas ORDER BY tipo ASC";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }



     /*
     * FUNÇÃO BUSCAR TODOS as Cidades
     */

    function busca_cidade_por_estado($id)
    {
        $this->pdo = new Connection();
        $query = "SELECT * FROM cidades WHERE uf = " . $id . " ORDER BY nome ASC;";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }

      /*
     * FUNÇÃO BUSCAR TODOS as Cidades por estado
     */

    function busca_estado_por_pais($id_pais)
    {
        $this->pdo = new Connection();
        $query = "SELECT * FROM estados WHERE pais = " . $id_pais . " ORDER BY nome ASC;";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }
     /*
     * FUNÇÃO BUSCAR TODOS OS Usuarios ATIVOS OU BLOQUEADOS
     */

     function desativar_cliente($hash) {
        $this->pdo = new Connection();
        $query = "UPDATE clientes_erp SET status = 'Inativo' WHERE hash = :hash";
        try {
            $stmt = $this->pdo->prepare($query, array("set names utf8"));
            $stmt->bindParam(':hash', $hash, PDO::PARAM_STR);
            if ($stmt->execute()) {
                return 1;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

     }

     /*
     * FUNÇÃO BUSCAR TODOS OS Fornecedores ATIVOS OU BLOQUEADOS
     */


    function busca_funcionarios() {
        $this->pdo = new Connection();
        $query = "SELECT * FROM funcionarios WHERE status <> 'Inativo'";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }

    
    function busca_funcionarios_por_cpf($cpf) {
        $this->pdo = new Connection();
        $query = "SELECT * FROM funcionarios WHERE status <> 'Inativo' AND cpf = :cpf";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }

    /*
     * FUNÇÃO BUSCAR TODOS OS ESTADOS CIVIS 
     */
    function busca_estado_civil() {
        $this->pdo = new Connection();
        $query = "SELECT * FROM estado_civil ORDER BY id ASC";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }

    /*
    * FUNÇÃO BUSCAR TODOS OS  PRODUTOS
    */

    function busca_produtos()
    {
        $this->pdo = new Connection();
        $query = "SELECT nome, custo, data_lancamento, id_fornecedor , fornecedores.nome_fantasia AS forn_nome, produtos.hash  AS hash_prod FROM produtos INNER JOIN fornecedores ON produtos.id_fornecedor = fornecedores.hash WHERE produtos.status <> 'Esgotado'";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }

    function busca_produtos_total()
    {
        $this->pdo = new Connection();
        $query = "SELECT * FROM produtos WHERE 'status' <> 'Inativo'";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }

    /*
    * FUNÇÃO BUSCAR TODOS OS  PRODUTOS
    */
    function busca_fornecedor_por_nome($nome_fantasia)
    {
        $this->pdo = new Connection();
        $query = "SELECT id FROM fornecedores WHERE nome_fantasia = " . $nome_fantasia ."";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }

      /*
     * FUNÇÃO BUSCAR TODOS OS PORTES DAS EMPRESAS
     */


    function busca_empresas_portes()
    {
        $this->pdo = new Connection();
        $query = "SELECT * FROM empresas_portes ORDER BY portes ASC";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }
    
    /*
     * FUNÇÃO BUSCAR TODOS OS Natureza Juridica
     */


    function busca_natureza_juridica()
    {
        $this->pdo = new Connection();
        $query = "SELECT * FROM naturezas_juridicas ORDER BY tipo ASC";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }







    
    /*
     * FUNÇÃO BUSCAR TODOS OS CARGOS 
     */
    function busca_cargos() 
    {
        $this->pdo = new Connection();
        $query = "SELECT * FROM cargos ORDER BY id ASC";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $result;
    }

    function converte_data($date)
    {
        $result = implode('-', array_reverse(explode('/', $date)));
        
        return $result;
        
    }



}
