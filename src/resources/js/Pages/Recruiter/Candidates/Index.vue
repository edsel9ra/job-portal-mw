<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <!--<p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                        Portal del reclutador
                    </p>-->

                    <h2 class="mt-1 text-xl font-black uppercase tracking-tight text-slate-950">
                        Candidatos
                    </h2>
                </div>

                <div v-if="candidates.meta"
                    class="inline-flex w-fit items-center rounded-2xl bg-white px-4 py-2 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-slate-200">
                    Página {{ candidates.meta.current_page }} de {{ candidates.meta.last_page }}
                </div>
            </div>
        </template>

        <div class="relative overflow-hidden px-8 py-8">
            <div class="pointer-events-none absolute left-[-160px] top-0 h-80 w-80 rounded-full bg-red-500/10 blur-3xl">
            </div>
            <div
                class="pointer-events-none absolute right-[-180px] top-40 h-96 w-96 rounded-full bg-blue-700/10 blur-3xl">
            </div>

            <div class="relative mx-auto max-w-6xl space-y-6">
                <!-- HERO -->
                <section
                    class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 p-6 text-white shadow-2xl shadow-slate-300/60 sm:p-8">
                    <div
                        class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-red-600/30 blur-3xl">
                    </div>
                    <div
                        class="pointer-events-none absolute -bottom-24 left-10 h-72 w-72 rounded-full bg-blue-600/20 blur-3xl">
                    </div>

                    <div class="relative grid gap-8 lg:grid-cols-[1fr_390px] lg:items-center">
                        <div>
                            <div
                                class="mb-5 inline-flex rounded-full bg-red-600/20 px-4 py-2 text-xs font-black uppercase tracking-[0.22em] text-red-100 ring-1 ring-red-400/20">
                                Gestión de candidatos
                            </div>

                            <h1 class="max-w-3xl text-3xl font-black leading-tight tracking-tight sm:text-4xl">
                                Visualiza los candidatos que han aplicado a tus ofertas.
                            </h1>

                            <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-300">
                                Consulta perfiles, currículums, aplicaciones y actualiza el estado de cada proceso de
                                selección.
                            </p>

                            <!--<div class="mt-5 flex flex-wrap gap-2">
                                <span
                                    class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-3 py-2 text-xs font-bold text-slate-100 ring-1 ring-white/10">
                                    <span class="material-symbols-outlined text-[16px] text-red-300">groups</span>
                                    {{ totalCandidates }} candidatos
                                </span>

                                <span
                                    class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-3 py-2 text-xs font-bold text-slate-100 ring-1 ring-white/10">
                                    <span
                                        class="material-symbols-outlined text-[16px] text-red-300">manage_search</span>
                                    Búsqueda rápida
                                </span>
                            </div>-->
                        </div>

                        <!-- Buscador -->
                        <div class="rounded-3xl bg-white/10 p-4 shadow-xl ring-1 ring-white/10 backdrop-blur">
                            <p class="mb-3 text-sm font-bold text-white">
                                Buscar candidato
                            </p>

                            <div class="relative">
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                                    <span class="material-symbols-outlined text-[20px]">search</span>
                                </div>

                                <input v-model="search" type="text" placeholder="Buscar por nombre o email..."
                                    class="w-full rounded-2xl border border-white/10 bg-white py-3 pl-12 pr-12 text-sm font-medium text-slate-800 shadow-lg outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-4 focus:ring-red-500/20"
                                    @input="onSearch" />

                                <button v-if="search" type="button"
                                    class="absolute inset-y-0 right-4 flex items-center text-sm font-black text-slate-400 transition hover:text-red-600"
                                    @click="clearSearch">
                                    ×
                                </button>
                            </div>

                            <p class="mt-3 text-xs leading-5 text-slate-300">
                                Puedes buscar por nombre, correo u otros datos asociados al candidato.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Resumen -->
                <!--<section
                    class="flex flex-col gap-4 rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-black text-slate-950">
                            Candidatos registrados
                        </p>

                        <p class="mt-1 text-sm text-slate-500">
                            {{ hasCandidates ? 'Estos candidatos han aplicado a las ofertas.' : 'No se encontraron candidatos con los filtros aplicados.' }}
                        </p>
                    </div>

                    <div
                        class="inline-flex w-fit items-center rounded-2xl bg-slate-100 px-4 py-2 text-sm font-bold text-slate-700">
                        {{ totalCandidates }} resultado{{ totalCandidates === 1 ? '' : 's' }}
                    </div>
                </section>-->

                <!-- Grilla -->
                <section v-if="hasCandidates" class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                    <article v-for="candidate in candidates.data" :key="candidate.id"
                        class="group cursor-pointer overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-red-200 hover:shadow-xl hover:shadow-slate-200/80"
                        @click="openProfile(candidate)">
                        <div class="p-5">
                            <!-- Header card -->
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex min-w-0 items-center gap-3">
                                    <div
                                        class="flex h-14 w-14 flex-shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-slate-100 ring-1 ring-slate-200">
                                        <UserAvatar :name="candidate.user?.name" :photo="candidate.photo" size="md"
                                            alt="Foto del candidato" />
                                    </div>

                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-black text-slate-900">
                                            {{ candidate.user?.name }}
                                        </p>

                                        <p class="mt-0.5 truncate text-sm font-medium text-slate-400">
                                            {{ candidate.user?.email }}
                                        </p>
                                    </div>
                                </div>

                                <span
                                    class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-400 transition group-hover:bg-red-50 group-hover:text-red-600">
                                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                                </span>
                            </div>

                            <!-- Badges -->
                            <div class="mt-5 flex flex-wrap gap-2">
                                <span v-if="candidate.resume"
                                    class="inline-flex items-center gap-1 rounded-full border border-green-200 bg-green-50 px-3 py-1 text-xs font-black text-green-700">
                                    <span class="material-symbols-outlined text-[14px]">description</span>
                                    Con currículum
                                </span>

                                <span v-else
                                    class="inline-flex items-center gap-1 rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-bold text-slate-400">
                                    <span class="material-symbols-outlined text-[14px]">description</span>
                                    Sin currículum
                                </span>

                                <span v-if="candidate.city"
                                    class="inline-flex items-center gap-1 rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-black text-blue-700">
                                    <span class="material-symbols-outlined text-[14px]">location_on</span>
                                    {{ candidate.city }}
                                </span>
                            </div>

                            <!-- Info rápida -->
                            <div class="mt-5 space-y-3">
                                <div
                                    class="flex items-center justify-between gap-3 rounded-2xl bg-slate-50 px-4 py-3 text-sm">
                                    <span class="font-medium text-slate-500">Documento</span>

                                    <span class="truncate font-black text-slate-800">
                                        {{
                                            candidate.document_type && candidate.document_number
                                                ? `${candidate.document_type} · ${candidate.document_number}`
                                                : 'No registrado'
                                        }}
                                    </span>
                                </div>

                                <div
                                    class="flex items-center justify-between gap-3 rounded-2xl bg-slate-50 px-4 py-3 text-sm">
                                    <span class="font-medium text-slate-500">Celular</span>

                                    <span class="truncate font-black text-slate-800">
                                        {{ candidate.phone || 'No registrado' }}
                                    </span>
                                </div>

                                <div
                                    class="flex items-center justify-between gap-3 rounded-2xl bg-slate-50 px-4 py-3 text-sm">
                                    <span class="font-medium text-slate-500">Nacimiento</span>

                                    <span class="truncate font-black text-slate-800">
                                        {{ formatBirthDate(candidate.birth_date) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">
                                <span class="text-xs font-medium text-slate-400">
                                    Click para abrir el perfil
                                </span>

                                <button type="button"
                                    class="text-sm font-black text-slate-900 transition hover:text-red-600"
                                    @click.stop="openProfile(candidate)">
                                    Ver detalle
                                </button>
                            </div>
                        </div>
                    </article>
                </section>

                <!-- Empty state -->
                <section v-else
                    class="rounded-[2rem] border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">
                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-slate-100 text-slate-500">
                        <span class="material-symbols-outlined text-[34px]">person_search</span>
                    </div>

                    <h3 class="mt-5 text-lg font-black text-slate-950">
                        {{ filters.q ? 'Sin resultados para la búsqueda' : 'Aún no hay candidatos' }}
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                        Cuando los candidatos apliquen a tus ofertas, aparecerán en esta sección.
                    </p>

                    <button v-if="search" type="button"
                        class="mt-6 rounded-2xl bg-red-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-red-600/25 transition hover:bg-red-700"
                        @click="clearSearch">
                        Limpiar búsqueda
                    </button>
                </section>

                <!-- Paginación -->
                <section v-if="candidates.meta?.last_page > 1"
                    class="flex flex-col items-center justify-between gap-4 rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm sm:flex-row">
                    <p class="text-sm font-medium text-slate-500">
                        Mostrando página
                        <span class="font-black text-slate-800">{{ candidates.meta.current_page }}</span>
                        de
                        <span class="font-black text-slate-800">{{ candidates.meta.last_page }}</span>
                    </p>

                    <div class="flex items-center gap-2">
                        <button type="button"
                            class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-600 disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:border-slate-200 disabled:hover:bg-white disabled:hover:text-slate-700"
                            :disabled="!candidates.links?.prev" @click="goPage(candidates.meta.current_page - 1)">
                            ← Anterior
                        </button>

                        <div class="rounded-2xl bg-slate-950 px-4 py-2.5 text-sm font-black text-white">
                            {{ candidates.meta.current_page }}
                        </div>

                        <button type="button"
                            class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-600 disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:border-slate-200 disabled:hover:bg-white disabled:hover:text-slate-700"
                            :disabled="!candidates.links?.next" @click="goPage(candidates.meta.current_page + 1)">
                            Siguiente →
                        </button>
                    </div>
                </section>
            </div>
        </div>

        <!-- MODAL PERFIL -->
        <Transition name="modal">
            <div v-if="modal.open"
                class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 p-4 backdrop-blur-sm"
                @click.self="closeModal">
                <div
                    class="flex max-h-[92vh] w-full max-w-5xl flex-col overflow-hidden rounded-[2rem] bg-white shadow-2xl shadow-black/40">
                    <!-- Header modal -->
                    <div
                        class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 px-6 py-6 text-white">
                        <div
                            class="pointer-events-none absolute -right-16 -top-16 h-44 w-44 rounded-full bg-red-600/30 blur-3xl">
                        </div>

                        <div class="relative flex items-start justify-between gap-4">
                            <div class="flex min-w-0 items-center gap-4">
                                <!--<div v-if="modal.profile?.photo"
                                    class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-3xl bg-white/10 ring-1 ring-white/20">
                                    <img :src="`/storage/${modal.profile.photo}`" alt="Foto del candidato"
                                        class="h-full w-full object-cover" />
                                </div>

                                <div v-else
                                    class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-3xl bg-white/10 text-slate-300 ring-1 ring-white/20">
                                    <span class="material-symbols-outlined text-[32px]">person</span>
                                </div>-->

                                <div class="min-w-0">
                                    <!--<p class="text-xs font-black uppercase tracking-[0.22em] text-red-200">
                                        Perfil del candidato
                                    </p>-->

                                    <h3 class="mt-2 truncate text-lg font-black text-white tracking-tight">
                                        {{ modal.profile?.user?.name ?? 'Candidato' }} - {{ modal.profile?.user?.email ?? 'Sin correo' }}
                                    </h3>

                                    <!--<p class="mt-1 truncate text-sm text-slate-300">
                                        {{ modal.profile?.user?.email ?? 'Sin correo' }}
                                    </p>-->
                                </div>
                            </div>

                            <button type="button"
                                class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-3xl bg-white/10 text-white transition hover:bg-white/20"
                                @click="closeModal">
                                ✕
                            </button>
                        </div>
                    </div>

                    <!-- Loading -->
                    <div v-if="modal.loading" class="flex flex-1 items-center justify-center py-20">
                        <div class="flex flex-col items-center gap-3 text-sm font-semibold text-slate-400">
                            <span
                                class="h-8 w-8 animate-spin rounded-full border-4 border-slate-200 border-t-red-600"></span>
                            Cargando perfil...
                        </div>
                    </div>

                    <!-- Contenido -->
                    <div v-else class="flex min-h-0 flex-1 flex-col">
                        <!-- Tabs -->
                        <div class="border-b border-slate-100 bg-white px-4 pt-4">
                            <div class="flex flex-wrap gap-2">
                                <button v-for="tab in tabs" :key="tab.value" type="button"
                                    class="inline-flex items-center gap-2 rounded-2xl px-4 py-2.5 text-sm font-black transition"
                                    :class="modal.tab === tab.value
                                        ? 'bg-red-600 text-white shadow-lg shadow-red-600/20'
                                        : 'bg-slate-100 text-slate-600 hover:bg-red-50 hover:text-red-600'"
                                    @click="modal.tab = tab.value">
                                    <span class="material-symbols-outlined text-[18px]">
                                        {{ tab.icon }}
                                    </span>

                                    {{ tab.label }}
                                </button>
                            </div>
                        </div>

                        <div class="flex-1 overflow-y-auto">
                            <!-- Tab: Perfil -->
                            <div v-if="modal.tab === 'perfil'" class="p-6">
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <InfoBox label="Tipo de documento"
                                        :value="modal.profile?.document_type || 'No registrado'" />

                                    <InfoBox label="Número de documento"
                                        :value="modal.profile?.document_number || 'No registrado'" />

                                    <InfoBox label="Celular" :value="modal.profile?.phone || 'No registrado'" />

                                    <InfoBox label="Fecha de nacimiento"
                                        :value="formatBirthDate(modal.profile?.birth_date)" />

                                    <InfoBox label="Ciudad" :value="modal.profile?.city || 'No registrada'"
                                        class="md:col-span-2" />
                                </div>
                            </div>

                            <!-- Tab: Curriculum -->
                            <div v-if="modal.tab === 'curriculum'" class="p-6">
                                <div v-if="modal.resume" class="space-y-6">
                                    <!-- Resumen -->
                                    <section v-if="modal.resume.summary"
                                        class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                                        <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                            Resumen
                                        </p>

                                        <p class="mt-3 text-sm leading-7 text-slate-600">
                                            {{ modal.resume.summary }}
                                        </p>
                                    </section>

                                    <!-- Experiencia -->
                                    <section v-if="modal.resume.work_experience?.length"
                                        class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                                        <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                            Experiencia
                                        </p>

                                        <div class="mt-5 space-y-5">
                                            <div v-for="(experience, index) in modal.resume.work_experience"
                                                :key="index" class="relative flex gap-4">
                                                <div class="flex flex-col items-center">
                                                    <div
                                                        class="flex h-10 w-10 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                                                        <span class="material-symbols-outlined text-[20px]">work</span>
                                                    </div>

                                                    <div v-if="index !== modal.resume.work_experience.length - 1"
                                                        class="mt-2 h-full w-px bg-slate-200"></div>
                                                </div>

                                                <div class="min-w-0 pb-2">
                                                    <p class="text-sm font-black text-slate-900">
                                                        {{ experience.position }}
                                                    </p>

                                                    <p class="mt-1 text-xs font-semibold text-slate-500">
                                                        {{ experience.company }}
                                                    </p>

                                                    <p class="mt-1 text-xs font-medium text-slate-400">
                                                        {{ formatDate(experience.start_date) }} —
                                                        {{ experience.end_date ? formatDate(experience.end_date) :
                                                        'Actualidad'
                                                        }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <!-- Educación -->
                                    <section v-if="modal.resume.education?.length"
                                        class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                                        <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                            Educación
                                        </p>

                                        <div class="mt-4 space-y-3">
                                            <div v-for="(education, index) in modal.resume.education" :key="index"
                                                class="rounded-2xl bg-slate-50 px-4 py-3">
                                                <p class="text-sm font-black text-slate-900">
                                                    {{ education.title }}
                                                </p>

                                                <p class="mt-1 text-xs font-semibold text-slate-500">
                                                    {{ education.school }} · {{ education.year }}
                                                </p>
                                            </div>
                                        </div>
                                    </section>

                                    <!-- Habilidades / Idiomas -->
                                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                        <section v-if="modal.resume.skills?.length"
                                            class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                                            <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                                Habilidades
                                            </p>

                                            <div class="mt-4 flex flex-wrap gap-2">
                                                <span v-for="(skill, index) in modal.resume.skills" :key="index"
                                                    class="rounded-full bg-red-50 px-3 py-1.5 text-xs font-bold text-red-700">
                                                    {{ skill }}
                                                </span>
                                            </div>
                                        </section>

                                        <section v-if="modal.resume.languages?.length"
                                            class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                                            <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                                Idiomas
                                            </p>

                                            <div class="mt-4 space-y-2">
                                                <div v-for="(language, index) in modal.resume.languages" :key="index"
                                                    class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 text-sm">
                                                    <span class="font-bold text-slate-700">
                                                        {{ language.name }}
                                                    </span>

                                                    <span
                                                        class="rounded-full bg-slate-950 px-3 py-1 text-xs font-black text-white">
                                                        {{ language.level }}
                                                    </span>
                                                </div>
                                            </div>
                                        </section>
                                    </div>

                                    <!-- PDF -->
                                    <div v-if="modal.resume.pdf_path"
                                        class="rounded-[2rem] border border-slate-200 bg-slate-50 p-5">
                                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                                                    <span class="material-symbols-outlined">picture_as_pdf</span>
                                                </div>

                                                <div>
                                                    <p class="text-sm font-black text-slate-900">
                                                        PDF del currículum
                                                    </p>

                                                    <p class="mt-1 text-xs font-medium text-slate-400">
                                                        Archivo adjunto por el candidato
                                                    </p>
                                                </div>
                                            </div>

                                            <a :href="modal.resume.pdf_url" target="_blank"
                                                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-red-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-red-600/20 transition hover:bg-red-700">
                                                Ver PDF
                                                <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div v-else
                                    class="rounded-[2rem] border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-slate-500 shadow-sm">
                                        <span class="material-symbols-outlined">description</span>
                                    </div>

                                    <p class="mt-4 text-sm font-black text-slate-700">
                                        Este candidato aún no tiene currículum registrado.
                                    </p>
                                </div>
                            </div>

                            <!-- Tab: Aplicaciones -->
                            <div v-if="modal.tab === 'aplicaciones'" class="space-y-5 p-6">
                                <article v-for="application in modal.applications" :key="application.id"
                                    class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                                    <div class="border-b border-slate-100 bg-slate-50 px-5 py-4">
                                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                            <div>
                                                <p class="text-sm font-black text-slate-900">
                                                    {{ application.job?.name_job }}
                                                </p>

                                                <p class="mt-1 text-xs font-medium text-slate-400">
                                                    Aplicó {{ timeAgo(application.applied_at) }}
                                                </p>
                                            </div>

                                            <span class="inline-flex w-fit rounded-full px-3 py-1 text-xs font-black"
                                                :class="pillClass(application.status)">
                                                {{ application.status }}
                                            </span>
                                        </div>
                                    </div>

                                    <div v-if="application.cover_letter" class="border-b border-slate-100 px-5 py-4">
                                        <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-400">
                                            Carta de presentación
                                        </p>

                                        <p class="mt-2 text-sm italic leading-6 text-slate-600">
                                            “{{ application.cover_letter }}”
                                        </p>
                                    </div>

                                    <div class="space-y-4 px-5 py-5">
                                        <p class="text-xs font-black uppercase tracking-[0.18em] text-red-600">
                                            Cambiar estado
                                        </p>

                                        <div class="flex flex-wrap items-start gap-2">
                                            <select v-model="appForms[application.id].status"
                                                class="rounded-2xl border border-slate-200 bg-slate-50 py-2.5 text-sm font-medium text-slate-700 outline-none transition focus:border-red-500 focus:bg-white focus:ring-4 focus:ring-red-500/20"
                                                @change="onStatusChange(application.id)">
                                                <option v-for="status in STATUSES" :key="status" :value="status">
                                                    {{ status }}
                                                </option>
                                            </select>

                                            <button type="button"
                                                class="rounded-2xl bg-red-600 px-5 py-2.5 text-sm font-black text-white shadow-lg shadow-red-600/20 transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-60"
                                                :disabled="appForms[application.id].saving"
                                                @click="saveStatus(application.id)">
                                                {{ appForms[application.id].saving ? 'Guardando...' : 'Guardar' }}
                                            </button>
                                        </div>

                                        <div v-if="appForms[application.id].status === 'Entrevista'"
                                            class="rounded-2xl border border-blue-100 bg-blue-50 px-4 py-4">
                                            <label class="text-xs font-black uppercase tracking-[0.18em] text-blue-700">
                                                ¿Cuántas entrevistas se realizarán?
                                            </label>

                                            <input v-model.number="appForms[application.id].interview_count"
                                                type="number" min="1" max="10" placeholder="Ej: 2"
                                                class="mt-2 w-32 rounded-2xl border border-blue-200 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20" />

                                            <p v-if="appForms[application.id].errors?.interview_count"
                                                class="mt-2 text-xs font-semibold text-red-500">
                                                {{ appForms[application.id].errors.interview_count }}
                                            </p>
                                        </div>

                                        <div v-if="appForms[application.id].status === 'Rechazado'"
                                            class="rounded-2xl border border-red-100 bg-red-50 px-4 py-4">
                                            <label class="text-xs font-black uppercase tracking-[0.18em] text-red-700">
                                                Motivo de rechazo
                                                <span class="text-red-500">*</span>
                                            </label>

                                            <textarea v-model="appForms[application.id].rejection_reason" rows="3"
                                                placeholder="Explica brevemente la razón del rechazo..."
                                                class="mt-2 w-full rounded-2xl border border-red-200 bg-white px-4 py-3 text-sm leading-6 outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-4 focus:ring-red-500/20" />

                                            <p v-if="appForms[application.id].errors?.rejection_reason"
                                                class="mt-2 text-xs font-semibold text-red-500">
                                                {{ appForms[application.id].errors.rejection_reason }}
                                            </p>
                                        </div>

                                        <p v-if="appForms[application.id].saved"
                                            class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-xs font-black text-green-700">
                                            Estado actualizado correctamente.
                                        </p>
                                    </div>
                                </article>

                                <div v-if="!modal.applications?.length"
                                    class="rounded-[2rem] border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-slate-500 shadow-sm">
                                        <span class="material-symbols-outlined">send</span>
                                    </div>

                                    <p class="mt-4 text-sm font-black text-slate-700">
                                        Este candidato no ha aplicado a ninguna de tus ofertas.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </AuthenticatedLayout>
</template>

<script setup>
import { computed, defineComponent, h, reactive, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useJobUtils } from '@/composables/useJobUtils';
import UserAvatar from '@/Components/UserAvatar.vue';

const { timeAgo } = useJobUtils();

const props = defineProps({
    candidates: { type: Object, required: true },
    filters: { type: Object, default: () => ({}) },
});

const STATUSES = ['Aplicado', 'En Revisión', 'Entrevista', 'Rechazado', 'Contratado'];

const search = ref(props.filters?.q ?? '');
let searchTimeout = null;

const totalCandidates = computed(() => props.candidates?.meta?.total ?? props.candidates?.data?.length ?? 0);
const hasCandidates = computed(() => (props.candidates?.data ?? []).length > 0);

const tabs = [
    { value: 'perfil', label: 'Perfil', icon: 'person' },
    { value: 'curriculum', label: 'Currículum', icon: 'description' },
    { value: 'aplicaciones', label: 'Aplicaciones', icon: 'send' },
];

function onSearch() {
    clearTimeout(searchTimeout);

    searchTimeout = setTimeout(() => {
        router.get(route('reclutador.candidatos.index'), { q: search.value }, {
            preserveState: true,
            replace: true,
        });
    }, 350);
}

function clearSearch() {
    search.value = '';

    router.get(route('reclutador.candidatos.index'), {}, {
        preserveState: true,
        replace: true,
    });
}

function goPage(page) {
    router.get(
        route('reclutador.candidatos.index'),
        { page, q: search.value || undefined },
        { preserveState: true }
    );
}

const modal = reactive({
    open: false,
    loading: false,
    tab: 'perfil',
    candidate: null,
    profile: null,
    resume: null,
    applications: [],
});

const appForms = reactive({});

async function openProfile(candidate) {
    modal.open = true;
    modal.loading = true;
    modal.tab = 'perfil';
    modal.candidate = candidate;

    try {
        const { data } = await axios.get(route('reclutador.candidates.profile', candidate.id));

        modal.profile = data.candidate ?? null;
        modal.resume = data.candidate?.resume ?? null;
        modal.applications = data.applications ?? [];

        modal.applications.forEach((app) => {
            appForms[app.id] = {
                status: app.status,
                rejection_reason: app.rejection_reason ?? '',
                interview_count: app.interview_count ?? null,
                saving: false,
                saved: false,
                errors: {},
            };
        });
    } catch (error) {
        console.error('Error cargando perfil', error);
    } finally {
        modal.loading = false;
    }
}

function closeModal() {
    modal.open = false;
    modal.candidate = null;
    modal.profile = null;
    modal.resume = null;
    modal.applications = [];
}

function onStatusChange(appId) {
    const form = appForms[appId];

    form.errors = {};
    form.saved = false;

    if (form.status !== 'Rechazado') form.rejection_reason = '';
    if (form.status !== 'Entrevista') form.interview_count = null;
}

async function saveStatus(appId) {
    const form = appForms[appId];

    form.saving = true;
    form.saved = false;
    form.errors = {};

    const body = { status: form.status };

    if (form.status === 'Rechazado') body.rejection_reason = form.rejection_reason;
    if (form.status === 'Entrevista') body.interview_count = form.interview_count;

    try {
        const { status } = await axios.patch(
            route('reclutador.candidates.applications.updateStatus', { application: appId }),
            body
        );

        if (status === 200) {
            form.saved = true;

            const application = modal.applications.find((item) => item.id === appId);

            if (application) application.status = form.status;

            setTimeout(() => {
                form.saved = false;
            }, 3000);
        }
    } catch (error) {
        if (error.response?.status === 422) {
            form.errors = error.response.data.errors ?? {};
        } else {
            console.error('Error guardando estado', error);
        }
    } finally {
        form.saving = false;
    }
}

function formatDate(str) {
    if (!str) return '';

    const [year, month] = str.split('-');

    const months = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic',];

    return `${months[parseInt(month) - 1]} ${year}`;
}

function formatBirthDate(date) {
    if (!date) return 'No registrada';

    const cleanDate = String(date).slice(0, 10);
    const [year, month, day] = cleanDate.split('-');

    if (!year || !month || !day) return 'No registrada';

    return `${day}/${month}/${year}`;
}

const STATUS_CONFIG = {
    Aplicado: 'bg-yellow-100 text-yellow-800',
    'En Revisión': 'bg-blue-100 text-blue-700',
    Entrevista: 'bg-purple-100 text-purple-700',
    Rechazado: 'bg-red-100 text-red-600',
    Contratado: 'bg-green-100 text-green-700',
};

function pillClass(status) {
    return STATUS_CONFIG[status] ?? 'bg-slate-100 text-slate-600';
}

const InfoBox = defineComponent({
    props: {
        label: {
            type: String,
            required: true,
        },
        value: {
            type: String,
            default: '',
        },
    },
    setup(props, { attrs }) {
        return () =>
            h(
                'div',
                {
                    ...attrs,
                    class:
                        'rounded-[2rem] border border-slate-200 bg-slate-50 p-5 ' +
                        (attrs.class ?? ''),
                },
                [
                    h(
                        'p',
                        {
                            class: 'text-xs font-black uppercase tracking-[0.18em] text-slate-400',
                        },
                        props.label
                    ),
                    h(
                        'p',
                        {
                            class: 'mt-2 text-sm font-black text-slate-800',
                        },
                        props.value
                    ),
                ]
            );
    },
});
</script>

<style scoped>
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}

.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.2s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}
</style>