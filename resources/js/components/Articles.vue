<template>
    <div class="container">
        <div>
            <h2>Articles</h2>
            <form @submit.prevent="addArticle">
                <div class="form-group mb-3">
                    <input type="text" name="title" placeholder="Title" v-model="article.title" class="form-control">
                </div>
                <div class="form-group">
                    <textarea name="description" id="" cols="20" rows="10" v-model="article.description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" v-if="edit" value="Update" class="btn btn-primary">
                    <input type="submit" v-else value="ADD" class="btn btn-primary">
                </div>
            </form>

            <nav aria-label="...">
                <ul class="pagination">
                    <li class="page-item" v-bind:class="[{disabled: !pagination.previous_page_url}]">
                        <a class="page-link" href="#" @click="fetchArticles(pagination.previous_page_url)">Previous</a>
                    </li>
                    <li class="page-item disbaled">
                        <a class="page-link" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page}}</a>
                    </li>

                    <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                        <a class="page-link" href="#" @click="fetchArticles(pagination.next_page_url)">Next</a>
                    </li>
                </ul>
            </nav>

            <div v-for="article in articles" v-bind:key="article.id" class="card-body">
                    <p> {{ article.created_at }}</p>
                    <h5 class="text-info">{{ article.title}}</h5>


                  <p>  {{ article.description}}</p>
                <hr>
                <button @click="deleteArticle(article.id)" class="btn btn-danger">Delete</button>
                <button @click="editArticle(article)" class="btn btn-info">Edit</button>

                <br><br>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        data(){
            return{
                articles: [],
                article: {
                    id: '',
                    title: '',
                    description : '',

                },
                article_id: '',
                pagination: {},
                edit: false,
                msg : '',
            }
        },

        created() {
            this.fetchArticles();
        },

        methods : {
            fetchArticles: function(page_url){
                let vm = this;
                page_url = page_url || 'api/articles';
                axios.get(page_url).then(response => {

                    this.articles = response.data.data;

                    vm.makePagination(response.data);
                })
                    .catch(error =>{
                        console.log(error);
                    })

            },
            makePagination: function (data) {

                let pagination = {
                    current_page : data.current_page,
                    last_page : data.last_page,
                    next_page_url : data.next_page_url,
                    previous_page_url : data.prev_page_url,
                };

                this.pagination = pagination;

            },

            deleteArticle: function (id) {

               if(confirm('Are you Sure ?')){
                   axios.delete(`api/article/${id}`).then(response =>{
                       this.msg = "Article Removed";
                       alert(this.msg);
                       window.location.reload();
                   }).catch(error =>{
                       console.log(error);
                   })
               }
            },

            addArticle: function(){

                if(this.edit ===false){
                    //Create
                    axios.post('api/article',{
                        title: this.article.title,
                        description: this.article.description,
                    }).then(response =>{
                        this.msg= "Article Added";
                        this.article.title = '';
                        this.article.description = '';
                        alert(this.msg);
                        window.location.reload();
                    }).catch(error =>{
                        console.log(error)
                    });
                }
                else{
                    //Update
                    axios.put('api/article',{
                        article_id: this.article.id,
                        title: this.article.title,
                        description: this.article.description,
                    }).then(response =>{
                        this.msg= "Article Updated";
                        this.article.title = '';
                        this.article.description = '';
                        alert(this.msg);
                        window.location.reload();
                    }).catch(error =>{
                        console.log(error);
                    })
                }
            },

            editArticle: function (article) {
                this.edit = true;
                this.article.id = article.id;
                this.article.title = article.title;
                this.article.description = article.description;
            }
        }
    }
</script>
