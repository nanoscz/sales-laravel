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
          <i class="fa fa-align-justify"></i> Income
          <button type="button" class="btn btn-secondary" @click="showDetail()">
            <i class="icon-plus"></i>&nbsp;Add
          </button>
        </div>
        <!-- list income -->
        <template v-if="list == 1">
          <div class="card-body">
            <div class="form-group row">
              <div class="col-md-6">
                <div class="input-group">
                  <select class="form-control col-md-3" v-model="option">
                    <option value="type_voucher">type_voucher</option>
                    <option value="num_voucher">num_voucher</option>
                    <option value="date">date / hour</option>
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
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th>Option</th>
                    <th>Name</th>
                    <th>Type Voucher</th>
                    <th>Series</th>
                    <th>Number</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Tax</th>
                    <th>Username</th>
                    <th>State</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="income in incomes" :key="income.id">
                    <td>
                      <button
                        type="button"
                        class="btn btn-success btn-sm"
                        @click="openModal('Income','update', income)"
                      >
                        <i class="icon-eye"></i>
                      </button> &nbsp;
                    </td>
                    <td v-text="income.name"></td>
                    <td v-text="income.type_voucher"></td>
                    <td v-text="income.series_voucher"></td>
                    <td v-text="income.num_voucher"></td>
                    <td v-text="income.date"></td>
                    <td v-text="income.total"></td>
                    <td v-text="income.tax"></td>
                    <td v-text="income.username"></td>
                    <td>
                      <div v-if="income.state">
                        <span @click="changeState(income.id)" class="badge badge-success">active</span>
                      </div>
                      <div v-else>
                        <span @click="changeState(income.id)" class="badge badge-danger">desactive</span>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm"></table>
            </div>
            <nav>
              <ul class="pagination">
                <li class="page-item" v-if="pagination.current_page > 1">
                  <a
                    class="page-link"
                    href="#"
                    @click="changePage(pagination.current_page -1, search, option)"
                  >Ant</a>
                </li>
                <li
                  class="page-item"
                  v-for="pag in pagesNumber"
                  :key="pag"
                  :class="[page = isActived ? 'active': '']"
                >
                  <a
                    class="page-link"
                    href="#"
                    v-text="pag"
                    @click="changePage(pag, search, option)"
                  ></a>
                </li>
                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                  <a
                    class="page-link"
                    href="#"
                    @click="changePage(pagination.current_page + 1, search, option)"
                  >Sig</a>
                </li>
              </ul>
            </nav>
          </div>
        </template>

        <!-- add income -->
        <template v-else>
          <div class="card-body">
            <div class="form-group row border">
              <div class="col-md-9">
                <div class="form-group">
                  <label for="provider">Provider</label>
                  <v-select
                    :on-search="selectProviders"
                    label="name"
                    :options="providers"
                    placeholder="Search provides..."
                    :onChange="getProvider"
                  ></v-select>
                </div>
              </div>
              <div class="col-md-3">
                <label for>Tax</label>
                <input type="text" class="form-control" v-model="tax">
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="provider">Type Voucher</label>
                  <select class="form-control" v-model="type_voucher">
                    <option value="0">Select</option>
                    <option value="BILL">Bill</option>
                    <option value="TICKET">Ticket</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Series Voucher</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="series_voucher"
                    placeholder="000000"
                  >
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Number Voucher</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="num_voucher"
                    placeholder="000000"
                  >
                </div>
              </div>
              <div class="col-md-12">
                <div v-show="err" class="form-group row div-error">
								  <div class="text-center text-error">
									 <div v-for="error in listErr" :key="error" v-text="error">
									 </div>
								  </div>
							  </div> 
              </div>
            </div>
            <div class="form-group row border">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Article
                    <span style="color:red" v-show="id_article == 0">(*)</span>
                  </label>
                  <div class="form-inline">
                    <input
                      type="text"
                      class="form-control"
                      v-model="code"
                      placeholder="article"
                      @keyup.enter="getArticles()"
                    >
                    <button class="btn btn-primary" @click="openModal()">...</button>
                    <input type="text" readonly class="form-control" v-model="article">
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="price">Price
                    <span style="color:red" v-show="price == 0">(*)</span>
                  </label>
                  <input type="number" step="any" value="0" class="form-control" v-model="price">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="quantity">Quantity
                    <span style="color:red" v-show="quantity == 0">(*)</span>
                  </label>
                  <input type="number" step="any" value="0" class="form-control" v-model="quantity">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <button @click="addArticleDetail()" class="btn btn-success form-control btn-add">
                    <i class="icon-plus"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="form-group row border">
              <div class="table-responsive col-md-12">
                <table class="table table-bordered table-striped table-sm">
                  <thead>
                    <tr>
                      <th>Option</th>
                      <th>Article</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>SubTotal</th>
                    </tr>
                  </thead>
                  <tbody v-if="details.length">
                    <tr v-for="(detail, index) in details" :key="detail.id">
                      <td>
                        <button
                          type="button"
                          class="btn btn-danger btn-sm"
                          @click="removeArticleDetail(index)"
                        >
                          <div class="icon-close"></div>
                        </button>
                      </td>
                      <td v-text="detail.article"></td>
                      <td>
                        <input type="number" v-model="detail.price" class="form-control">
                      </td>
                      <td>
                        <input type="number" v-model="detail.quantity" class="form-control">
                      </td>
                      <td>{{ detail.price * detail.quantity }}</td>
                    </tr>
                    <tr style="background-color: #CEECF5">
                      <td colspan="4" align="right">
                        <strong>Total Partial</strong>
                      </td>
                      <td>$ {{ totalPartial = (total - totalTax).toFixed(2)}}</td>
                    </tr>
                    <tr style="background-color: #CEECF5">
                      <td colspan="4" align="right">
                        <strong>Total Tax</strong>
                      </td>
                      <td>$ {{ totalTax=((total*tax)/(1+tax)).toFixed(2)}}</td>
                    </tr>
                    <tr style="background-color: #CEECF5">
                      <td colspan="4" align="right">
                        <strong>Total</strong>
                      </td>
                      <td>${{ total = calculateTotal }}</td>
                    </tr>
                  </tbody>
                  <tbody>
                    <h3>Not Found</h3>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <button type="button" class="btn btn-secondary" @click="closeDetail()">Close</button>
                <button type="button" class="btn btn-primary" @click="registerIncome()">Register</button>
              </div>
            </div>
          </div>
        </template>
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
      :class="{'show-modal': modal}"
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
            <!-- modalarticles -->
             <div class="form-group row">
              <div class="col-md-6">
              <div class="input-group">
                <select class="form-control col-md-3" v-model="optionArticles">
									<option value="code">Code</option>
                  <option value="name">Name</option>
                  <option value="description">Description</option>
                </select>
                <input
                  type="text"
                  v-model="searchArticles"
                  class="form-control"
									@keyup.enter="showArticles(searchArticles, optionArticles)"
                  placeholder="Seach..."
                >
                <button type="submit" class="btn btn-primary" @click="showArticles(searchArticles, optionArticles)">
                  <i class="fa fa-search"></i> Search
                </button>
              </div>
            </div>
            </div>
            <div class="table-responsive">
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
                        class="btn btn-success btn-sm"
                        @click="addDetailArticleModal(article)"
                      >
                        <i class="icon-check"></i>
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
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
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
import vSelect from "vue-select";
export default {
  data() {
    return {
      id: 0,
      id_provider: 0,
      type_voucher: "BILL",
      series_voucher: "",
      num_voucher: "",
      tax: 0.18,
      total: 0,
      code: "",
      id_article: 0,
      article: "",
      price: 0,
      quantity: 0,
      incomes: [],
      details: [],
      providers: [],
      articles: [],
      list: 1,
      modal: 0,
      titleModal: "",
      typeAction: 0,
      err: 0,
      listErr: [],
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      },
      totalTax: 0.0,
      totalPartial: 0.0,
      offset: 3,
      option: "num_voucher",
      search: "",
      optionArticles: "name",
      searchArticles: ""
    };
  },
  components: {
    vSelect
  },
  computed: {
    isActived: function() {
      return;
    },
    pagesNumber: function() {
      if (!this.pagination.to) {
        return [];
      }

      let from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }

      let to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }

      let pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    },
    calculateTotal: function() {
      let total = 0;
      for (let i = 0; i < this.details.length; i++) {
        total = total + this.details[i].price * this.details[i].quantity;
      }
      return total;
    }
  },
  methods: {
    show(page, search, option) {
      let ctrl = this;
      let url =
        "/income?page=" + page + "&search=" + search + "&option=" + option;
      axios
        .get(url)
        .then(function(res) {
          let response = res.data;
          ctrl.incomes = response.incomes.data;
          ctrl.pagination = response.pagination;
        })
        .catch(function(err) {
          console.error(err);
        });
    },
    showArticles(searchArticles, optionArticles){
      let ctrl = this;
			let url = '/articles/modal?search=' + searchArticles + '&option=' + optionArticles;
      axios
        .get(url)
        .then(function(res) {
					let response = res.data;
          ctrl.articles = response.articles.data;
        })
        .catch(function(err) {
          console.error(err);
        });
    },
    changePage(page, search, option) {
      let ctrl = this;
      //update current page
      ctrl.pagination.current_page = page;
      //send request show data page
      ctrl.show(page, search, option);
    },
    validate() {
      this.cleanError();
      if (this.id_provider == 0) this.listErr.push("Select Provider");
      if (this.type_voucher == 0) this.listErr.push("Field required type voucher");
      if (this.series_voucher == 0) this.listErr.push("Field required series voucher");
      if (!this.num_voucher) this.listErr.push("Field required number voucher");
      if (!this.tax) this.listErr.push("Field required tax!");
      if (this.details.length <= 0) this.listErr.push("Field required details articels!");
      if (this.listErr.length) this.err = 1;
      return this.err;
    },
    registerIncome() {
      if (this.validate()) {
        return;
      }
      let ctrl = this;
      let data = {
        id_provider: ctrl.id_provider,
        type_voucher: ctrl.type_voucher,
        series_voucher: ctrl.series_voucher,
        num_voucher: ctrl.num_voucher,
        tax: ctrl.tax,
        total: ctrl.total,
        data: ctrl.details
      };
      console.log({data});
      axios
        .post("/income", data)
        .then(function(res) {
          ctrl.list = 1;
          ctrl.show(1, "", "name");
          ctrl.cleanForm();
          console.log(res);
        })
        .catch(function(err) {
          console.error("error al register", err);
        });
    },
    selectProviders(search, loading) {
      let me = this;
      loading(true);

      var url = "/providers?filter=" + search;
      axios
        .get(url)
        .then(function(res) {
          let response = res.data;
          q: search;
          me.providers = response.providers;
          loading(false);
        })
        .catch(function(error) {
          console.error(error);
        });
    },
    getProvider(val1) {
      let me = this;
      me.loading = true;
      me.id_provider = val1.id;
    },
    getArticles() {
      let me = this;
      let url = "/articles?filter=" + me.code;
      axios
        .get(url)
        .then(function(response) {
          me.articles = response.data.articles;
          if (me.articles.length > 0) {
            me.article = me.articles[0]["name"];
            me.id_article = me.articles[0]["id"];
          } else {
            me.article = "not found";
            me.id_article = 0;
          }
        })
        .catch(function(err) {
          console.error(err);
        });
    },
    exists(id) {
      let exists = false;
      if (this.details.length) {
        for (let i = 0; i < this.details.length; i++) {
          if (this.details[i].id_article == id) {
            exists = true;
          }
        }
      }
      return exists;
    },
    removeArticleDetail(index) {
      let ctrl = this;
      ctrl.details.splice(index, 1);
    },
    addArticleDetail() {
      let ctrl = this;
      if (ctrl.id_article !== 0 && ctrl.quantity !== 0 && ctrl.price !== 0) {
        if (ctrl.exists(ctrl.id_article)) {
          Swal.fire({
            type: "error",
            title: "Error...",
            text: "The article has already been added"
            // footer: '<a href>Why do I have this issue?</a>'
          });
        } else {
          ctrl.details.push({
            id_article: ctrl.id_article,
            article: ctrl.article,
            quantity: ctrl.quantity,
            price: ctrl.price
          });
        }
      } else {
        console.log("Required id_article", ctrl.id_article);
        console.log("Required article", ctrl.article);
        console.log("Required quantity", ctrl.quantity);
        console.log("Required price", ctrl.price);
      }
    },
    addDetailArticleModal(data = []){
      let ctrl = this;
      if (ctrl.exists(data['id'])) {
          Swal.fire({
            type: "error",
            title: "Error...",
            text: "The article has already been added"
            // footer: '<a href>Why do I have this issue?</a>'
          });
        } else {
          ctrl.details.push({
            id_article: data['id'],
            article: data['name'],
            quantity: 1,
            price:1
          });
        }
    },
    openModal(model) {
      this.articles = [];
      this.modal = 1;
      this.titleModal = "Select one or more articles.";
    },
    showDetail() {
      this.list = 0;
    },
    closeDetail() {
      this.list = 1;
    },
    closeModal() {
      this.modal = 0;
      this.titleModal = "";
    },
    cleanError() {
      this.err = 0;
      this.listErr = [];
    },
    cleanForm(){
      let ctrl = this;
      ctrl.id_provider = 0;
      ctrl.type_voucher = 'BILL';
      ctrl.series_voucher = '';
      ctrl.num_voucher = '';
      ctrl.tax = 0.18;
      ctrl.total = 0.0;
      ctrl.article = '';
      ctrl.price = 0;
      ctrl.quantity = 0;
      ctrl.details = [];
    },
    changeState(id) {
      console.log("Income", id);
      let ctrl = this;
      let data = {
        id
      };
      const swalWithBootstrapButtons = Swal.mixin({
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false
      });

      swalWithBootstrapButtons
        .fire({
          title: "Change",
          text: "You want to change the state?",
          type: "warning",
          showCancelButton: true,
          confirmButtonText: "Yes, change!",
          cancelButtonText: "No, cancel!",
          reverseButtons: true
        })
        .then(result => {
          if (result.value) {
            swalWithBootstrapButtons.fire(
              "Change!",
              "Change Sucessfull.",
              "success"
            );
            axios
              .put("/Income/state", data)
              .then(function(res) {
                ctrl.show(1, "", "name");
              })
              .catch(function(err) {
                console.error(err);
              });
          } else if (
            // Read more about handling dismissals
            result.dismiss === Swal.DismissReason.cancel
          ) {
            swalWithBootstrapButtons.fire(
              "Cancelled",
              "Change Canceled.",
              "error"
            );
            console.log("B");
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
.show-modal {
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
@media (min-width: 600px) {
  .btn-add {
    margin-top: 2rem;
  }
}
</style>