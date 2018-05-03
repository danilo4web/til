			jQuery("#uploadBtn_arquivo").change(function () {
				jQuery("#uploadFile_arquivo").val(this.value);

				if(this.files[0].size > 1048576) {
					swal({ title: "Atenção:", text: "Arquivo maior que 1Mb será importado em background!" });
					jQuery("#ImportarTypeImport2").iCheck("check");
				} 
			});