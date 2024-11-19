<script setup>

    //import ref and onMounted
    import { ref, onMounted } from 'vue';

    //import api
    import api from '../../api';

    //define state
    const projects = ref([]);

    //method fetchDataProjects
    const fetchDataProjects = async () => {

        //fetch data 
        await api.get('/api/projects')

        .then(response => {

            //set response data to state "projects"
            projects.value = response.data.data.data

        });
    }

    //run hook "onMounted"
    onMounted(() => {

        //call method "fetchDataProjects"
        fetchDataProjects();
    });

    //method deleteProjects
    const deleteProject = async (id) => {
        
        //delete project with API
        await api.delete(`/api/projects/${id}`)
        .then(() => {

            //call method "fetchDataProjects"
            fetchDataProjects();
        })

    };

</script>

<template>
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <router-link :to="{ name: 'projects.create' }" class="btn btn-md btn-success rounded shadow border-0 mb-3">ADD NEW PROJECT</router-link>
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th scope="col">Thumbnail</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Link</th>
                                    <th scope="col">Author</th>
                                    <th scope="col" style="width:15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="projects.length == 0">
                                    <td colspan="7" class="text-center">
                                        <div class="alert alert-danger mb-0">
                                            Data Belum Tersedia!
                                        </div>
                                    </td>
                                </tr>
                                <tr v-else v-for="(project, index) in projects" :key="index">
                                    <td class="text-center">
                                        <img :src="project.thumbnail" width="200" class="rounded-3"/>
                                    </td>
                                    <td>{{ project.title }}</td>
                                    <td>{{ project.description }}</td>
                                    <td>{{ project.type }}</td>
                                    <td>{{ project.link }}</td>
                                    <td>{{ project.author }}</td>
                                    <td class="text-center">
                                        <router-link :to="{ name: 'projects.edit', params:{id: project.id} }" class="btn btn-sm btn-primary rounded-sm shadow border-0 me-2">EDIT</router-link>
                                        <button @click.prevent="deleteProject(project.id)" class="btn btn-sm btn-danger rounded-sm shadow border-0">DELETE</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>