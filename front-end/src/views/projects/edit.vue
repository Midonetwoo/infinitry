<script setup>
    //import ref
    import { ref, onMounted } from "vue";

    //import router
    import { useRouter, useRoute } from "vue-router";

    //import api
    import api from "../../api";

    //init router
    const router = useRouter();

    //init route
    const route = useRoute();

    //define state
    const thumbnail = ref("");
    const title = ref("");
    const description = ref("");
    const type = ref("");
    const link = ref("");
    const author = ref("");
    const errors = ref([]);

    //onMounted
    onMounted( async () => {

        //fetch detail data project by ID
        await api.get(`/api/projects/${route.params.id}`)
        .then(response => {

            //set response data to state
            title.value = response.data.data.title
            description.value = response.data.data.description
            type.value = response.data.data.type
            link.value = response.data.data.link
            author.value = response.data.data.author
        });
    })

    //method for handle file changes
    const handleFileChange = (e) => {
        //assign file to state
        thumbnail.value = e.target.files[0];
    };

    //method "updateProjects"
    const updateProjects = async () => {

        //init formData
        let formData = new FormData();

        //assign state value to formData
        formData.append("thumbnail", thumbnail.value);
        formData.append("title", title.value);
        formData.append("description", description.value);
        formData.append("type", type.value);
        formData.append("link", link.value);
        formData.append("author", author.value);
        formData.append("_method", "PATCH");

        //store data with API
        await api.post(`/api/projects/${route.params.id}`, formData)
        .then(() => {
            //redirect
            router.push({ path: "/projects" });
        })
        .catch((error) => {
            //assign response error data to state "errors"
            errors.value = error.response.data;
        });
    };
</script>

<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <form @submit.prevent="updateProjects()">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Thumbnail</label>
                                <input type="file" class="from-control" @change="handleFileChange($event)">
                                <div v-if="errors.thumbnail" class="alert alert-danger mt-2">
                                    <span>{{ errors.thumbnail[0] }}</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Title</label>
                                <input type="text" class="from-control" v-model="title" placeholder="Title Projects">
                                <div v-if="errors.title" class="alert alert-danger mt-2">
                                    <span>{{ errors.title[0] }}</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <input type="text" class="from-control" v-model="description" placeholder="Description Projects">
                                <div v-if="errors.description" class="alert alert-danger mt-2">
                                    <span>{{ errors.description[0] }}</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Type</label>
                                <input type="text" class="from-control" v-model="type" placeholder="Type Projects">
                                <div v-if="errors.type" class="alert alert-danger mt-2">
                                    <span>{{ errors.type[0] }}</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Link</label>
                                <input type="text" class="from-control" v-model="link" placeholder="Link Projects">
                                <div v-if="errors.link" class="alert alert-danger mt-2">
                                    <span>{{ errors.link[0] }}</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Author</label>
                                <input type="text" class="from-control" v-model="author" placeholder="Author Projects">
                                <div v-if="errors.author" class="alert alert-danger mt-2">
                                    <span>{{ errors.author[0] }}</span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-md btn-primary rounded-sm shadow border-0">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</template>