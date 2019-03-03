<template>
  <main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <li class="breadcrumb-item">
        <a href="#">Admin</a>
      </li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Article
          <button
            type="button"
            class="btn btn-secondary"
						@click="openModal('article','register')">
            <i class="icon-plus"></i>&nbsp;Add
          </button>
        </div>
        <div class="card-body">
          <div class="form-group row">
            <div class="col-md-6">
              <div class="input-group">
                <select class="form-control col-md-3" v-model="option">
									<option value="code">Code</option>
                  <option value="name">Name</option>
                  <option value="description">Description</option>
                </select>
                <input
                  type="text"
                  v-model="search"
                  class="form-control"
									@keyup.enter="show(1,search, option)"
                  placeholder="Seach..."
                >
                <button type="submit" class="btn btn-primary" @click="show(1, search, option)">
                  <i class="fa fa-search"></i> Search
                </button>
              </div>
            </div>
          </div>
          <table class="table table-bordered table-striped table-sm">
            <thead>
              <tr>
                <th>Option</th>
								<th>Code</th>
                <th>Name</th>
								<th>Category</th>
                <th>Description</th>
								<th>Price</th>
								<th>Stock</th>
                <th>State</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="article in articles" :key="article.id">
                <td>
                  <button
                    type="button"
                    class="btn btn-warning btn-sm"
										@click="openModal('article','update', article)">
                    <i class="icon-pencil"></i>
                  </button> &nbsp;
                  <button
                    type="button"
                    class="btn btn-danger btn-sm"
										@click="openModal('article','register')"
										>
                    <i class="icon-trash"></i>
                  </button>
                </td>
								<td v-text="article.code"></td>
                <td v-text="article.name"></td>
								<td v-text="article.category"></td>
                <td v-text="article.description"></td>
							 	<td v-text="article.price"></td>
							  <td v-text="article.stock"></td>
                <td>
									<div v-if="article.state">
                  	<span @click="changeState(article.id)" class="badge badge-success">active</span>
									</div>
									<div v-else>
                  	<span @click="changeState(article.id)" class="badge badge-danger">desactive</span>
									</div>
                </td>
              </tr>
            </tbody>
          </table>
          <nav>
            <ul class="pagination">
              <li class="page-item" v-if="pagination.current_page > 1">
                <a class="page-link" href="#" @click="changePage(pagination.current_page -1, search, option)">Ant</a>
              </li>
              <li class="page-item" v-for="pag in pagesNumber" :key="pag" 
								:class="[page = isActived ? 'active': '']">
                <a class="page-link" href="#" v-text="pag" @click="changePage(pag, search, option)"></a>
              </li>
              <li class="page-item"  v-if="pagination.current_page < pagination.last_page">
                <a class="page-link" href="#" @click="changePage(pagination.current_page + 1, search, option)">Sig</a>
               </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div
      class="modal fade"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myModalLabel"
      style="display: none;"
      aria-hidden="true"
			:class="{'show': modal}"
			>
      <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" v-text="titleModal"></h4>
            <button type="button" class="close" aria-label="Close" @click="closeModal()">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form action method="post" enctype="multipart/form-data" class="form-horizontal">
							<div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Category</label>
                <div class="col-md-9">
                  <select class="form-control" v-model="id_category">
										<option value="0" disable>Select</option>
										<option v-for="category in categories" :key="category.id" :value="category.id" v-text="category.name"></option>
									</select>
                </div>
              </div>
							<div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Code</label>
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="code"
                    class="form-control"
                    placeholder="Code"
                  >
									<barcode :value="code" :option="{format: 'EAN-13'}">
									</barcode>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Name</label>
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="name"
                    class="form-control"
                    placeholder="Name"
                  >
                </div>
              </div>
							<div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Price</label>
                <div class="col-md-9">
                  <input
                    type="number"
                    v-model="price"
                    class="form-control"
                  >
                </div>
              </div>
							<div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Stock</label>
                <div class="col-md-9">
                  <input
                    type="number"
                    v-model="stock"
                    class="form-control"
                  >
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Description</label>
                <div class="col-md-9">
                  <input
                    type="email"
										v-model="description"
                    class="form-control"
                    placeholder="Description"
                  >
                </div>
              </div>
							 <div v-show="err" class="form-group row div-error">
								 <div class="text-center text-error">
									 <div v-for="error in listErr" :key="error" v-text="error">
									 </div>
								 </div>
							 </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
            <div v-if="typeAction == 1">
							<button type="button" class="btn btn-success" @click="save()">Save</button>
						</div>
						<div  v-if="typeAction == 2">
							<button type="button" class="btn btn-primary" @click="update()">Update</button>
						</div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
    <!-- Inicio del modal Eliminar -->
    <div
      class="modal fade"
      id="modalEliminar"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myModalLabel"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-danger" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Eliminar Categoría</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Estas seguro de eliminar la categoría?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-danger">Eliminar</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- Fin del modal Eliminar -->
  </main>
</template>

<script>
import VueBarcode from 'vue-barcode';
export default {
  data() {
    return {
			id: 0,
			id_category: 0,
			category:'',
			code: '',
			name: '',
			price: 0,
			stock: 0,
      description: '',
			articles: [],
			modal: 0,
			titleModal: '',
			typeAction: 0,
			err: 0,
			listErr: [],
			pagination: {
				total: 0,
				current_page: 0,
				per_page: 0,
				last_page: 0,
				from: 0,
				to:0
			},
			offset: 3,
			option:'name',
			search:'',
			categories: []
    };
	},
	components: {
		'barcode': VueBarcode
	},
	computed: {
		isActived: function () {
			return 
		},
		pagesNumber: function() {
			if (!this.pagination.to) {
				return []
			}

			let from = this.pagination.current_page - this.offset;
			if (from < 1) {
				from = 1;
			}

			let to = from + (this.offset * 2);
			if (to >= this.pagination.last_page) {
				to = this.pagination.last_page;
			}

			let pagesArray= [];
			while(from <= to){
				pagesArray.push(from);
				from++;
			}
			return pagesArray;
		}
	},
  methods: {
    show(page, search, option) {
			let ctrl = this;
			let url = '/article?page=' + page + '&search=' + search + '&option=' + option;
      axios
        .get(url)
        .then(function(res) {
					let response = res.data;
					ctrl.articles = response.articles.data;
					ctrl.pagination = response.pagination;
        })
        .catch(function(err) {
          console.error(err);
        });
		},
		getCategories() {
			let ctrl = this;
      axios
        .get('/categories')
        .then(function(res) {
					let response = res.data;
					ctrl.categories = response.categories;
        })
        .catch(function(err) {
          console.error(err);
        });
		},
		changePage(page, search, option){
			let ctrl = this;
			//update current page
			ctrl.pagination.current_page = page;
			//send request show data page
			ctrl.show(page, search, option);
		},
		validate(){
			this.clearError();
			if (!this.name) this.listErr.push('Field required name!')
			if (!this.code) this.listErr.push('Field required code!')
			if (!this.price) this.listErr.push('Field required price!')
			if (!this.stock) this.listErr.push('Field required stock!')
			if (!this.id_category) this.listErr.push('Field required category!')
			if (this.listErr.length) this.err = 1
			return this.err;
		},
		save() {
			if (this.validate()) {
				return; 
			}
			let ctrl = this;
			let data = {
				'id_category': ctrl.id_category,
				'name': ctrl.name,
				'code': ctrl.code,
				'price': ctrl.price,
				'stock': ctrl.stock,
				'description': ctrl.description 
			};
      axios
        .post("/article", data)
        .then(function(res) {
					// me.articles.push(data)
					ctrl.show(1, '', 'name');
					ctrl.closeModal();
					console.log(res);
        })
        .catch(function(err) {
          console.error('error al register', err);
        });
		},
		update() {
			if (this.validate()) {
				return; 
			}
			let ctrl = this;
				let data = {
				'id': ctrl.id,
				'id_category': ctrl.id_category,
				'name': ctrl.name,
				'code': ctrl.code,
				'price': ctrl.price,
				'stock': ctrl.stock,
				'description': ctrl.description 
			};
      axios
        .put("/article", data)
        .then(function(res) {
					ctrl.show(1, '', 'name');
					ctrl.closeModal();
          console.log(res);
        })
        .catch(function(err) {
          console.error(err);
        });
		},
		openModal(model, action, data = []) {
			switch (model) {
				case "article":
				{
					switch (action) {
						case "register":
						{
							this.clearError();
							this.modal = 1;
							this.typeAction = 1;
							this.titleModal = 'Register Article'
							this.clearField()
							break;
						}
						case "update":
						{
							this.modal = 1;
							this.typeAction = 2;
							this.titleModal = 'Update Article';
							this.id = data['id'];
							this.id_category = data['id_category'];
							this.code = data['code'];
							this.name = data['name'];
							this.price = data['price'];
							this.stock = data['stock'];
							this.description = data['description'];
						}
					}
				}
			}
			this.getCategories();
		},
		closeModal() {
			this.modal = 0;
			this.titleModal = '';
			this.clearField()
		},
		clearField() {
			this.id_category = 0,
			this.code = '',
			this.name = '';
			this.price = 0,
			this.stock = 0,
			this.description = '';
		},
		clearError(){
			this.err = 0;
			this.listErr = [];
		},
		changeState(id) {
			console.log('article',id);
			let ctrl = this;
			let data = {
				id
			};
			const swalWithBootstrapButtons = Swal.mixin({
				confirmButtonClass: 'btn btn-success',
				cancelButtonClass: 'btn btn-danger',
				buttonsStyling: false,
			})

			swalWithBootstrapButtons.fire({
				title: 'Change',
				text: "You want to change the state?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes, change!',
				cancelButtonText: 'No, cancel!',
				reverseButtons: true
			}).then((result) => {
				if (result.value) {
					swalWithBootstrapButtons.fire(
						'Change!',
						'Change Sucessfull.',
						'success'
					)
					axios
						.put("/article/state", data)
						.then(function(res) {
							ctrl.show(1, '', 'name');
						})
						.catch(function(err) {
							console.error(err);
						});
				} else if (
					// Read more about handling dismissals
					result.dismiss === Swal.DismissReason.cancel
				) {
					swalWithBootstrapButtons.fire(
						'Cancelled',
						'Change Canceled.',
						'error'
					)
						console.log('B')
				}
			});
		}
  },
  mounted() {
    this.show(1, this.search, this.option);
  }
};
</script>
<style>
	.modal-content {
		width: 100% !important;
		position: absolute !important;
	}
	.show {
		display: list-item !important;
		opacity: 1 !important;
		position: absolute !important;
		background-color: #3c29297a !important;
	}
	.div-error {
		display: flex;
		justify-content: center;
	}
	.text-error {
		color: red !important;
		font-weight: bold;
	}
</style>