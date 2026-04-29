import { createRouter, createWebHistory } from 'vue-router'

import JobsIndex from '../pages/JobsIndex.vue'
import JobsCreate from '../pages/JobsCreate.vue'
import JobsEdit from '../pages/JobsEdit.vue'
import JobsShow from '../../../Pages/Public/Jobs/Show.vue'

export default createRouter({
  history: createWebHistory('/ofertas'),
  routes: [
    { path: '/', name: 'jobs.index', component: JobsIndex },
    { path: '/crear', name: 'jobs.create', component: JobsCreate },
    { path: '/:id', name: 'jobs.show', component: JobsShow },          // 👈 (yo quitaría props:true)
    { path: '/:id/editar', name: 'jobs.edit', component: JobsEdit },    // 👈 (yo quitaría props:true)
  ],
})
