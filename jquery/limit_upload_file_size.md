			jQuery("#uploadBtn_arquivo").change(function () {
				jQuery("#uploadFile_arquivo").val(this.value);

				file = this.files[0];

				if(file.size > 1048576) {
					swal({ title: "Atenção:", text: "Arquivo maior que 1Mb será importado em background!" });
				} 
			});