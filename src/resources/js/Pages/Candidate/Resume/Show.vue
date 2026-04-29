<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <!--<p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                        Perfil profesional
                    </p>-->

                    <h2 class="mt-1 text-xl font-black uppercase tracking-tight text-slate-950">
                        Mi currículum
                    </h2>
                </div>

                <!--<div class="flex flex-wrap gap-2">
                    <Button :pt="ptButton"
                        class="!rounded-2xl !border-red-600 !bg-red-600 !px-4 !py-2.5 !text-sm !font-black !text-white !shadow-lg !shadow-red-600/25 hover:!border-red-700 hover:!bg-red-700"
                        label="Ver PDF" @click="openNewTab(route('candidato.resume.pdf.preview', resume.id))">
                        <template #icon>
                            <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                        </template>
                    </Button>

                    <Button :pt="ptButton" outlined
                        class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-sm !font-bold !text-slate-700 !shadow-sm hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
                        label="Editar" @click="goTo(route('candidato.resume.edit', resume.id))">
                        <template #icon>
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </template>
                    </Button>
                </div>-->
            </div>
        </template>

        <div class="relative overflow-hidden px-8 py-8">
            <div class="pointer-events-none absolute left-[-160px] top-0 h-80 w-80 rounded-full bg-red-500/10 blur-3xl">
            </div>
            <div
                class="pointer-events-none absolute right-[-180px] top-40 h-96 w-96 rounded-full bg-blue-700/10 blur-3xl">
            </div>

            <div class="relative mx-auto max-w-6xl space-y-6">
                <Message v-if="$page.props.flash?.success" :pt="ptMessage" severity="success" :closable="false"
                    class="!rounded-2xl !border !border-green-200 !bg-green-50 !text-green-700">
                    {{ $page.props.flash.success }}
                </Message>

                <!-- Hero -->
                <section
                    class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 p-6 text-white shadow-2xl shadow-slate-300/60 sm:p-8">
                    <div
                        class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-red-600/30 blur-3xl">
                    </div>
                    <div
                        class="pointer-events-none absolute -bottom-24 left-10 h-72 w-72 rounded-full bg-blue-600/20 blur-3xl">
                    </div>

                    <div class="relative grid gap-8 lg:grid-cols-[1fr_340px] lg:items-center">
                        <div>
                            <div
                                class="mb-5 inline-flex rounded-full bg-red-600/20 px-4 py-2 text-xs font-black uppercase tracking-[0.22em] text-red-100 ring-1 ring-red-400/20">
                                Currículum activo
                            </div>

                            <h1 class="max-w-3xl text-3xl font-black leading-tight tracking-tight sm:text-4xl">
                                Tu perfil profesional está listo para ser revisado.
                            </h1>

                            <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-300">
                                Aquí puedes consultar la información visible para los reclutadores, revisar tu PDF,
                                actualizar
                                tus datos o eliminar tu currículum.
                            </p>

                            <div class="mt-5 flex flex-wrap gap-2">
                                <span
                                    class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-3 py-2 text-xs font-bold text-slate-100 ring-1 ring-white/10">
                                    <span class="material-symbols-outlined text-[16px] text-red-300">work_history</span>
                                    {{ resume.work_experience?.length ?? 0 }} experiencias
                                </span>

                                <span
                                    class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-3 py-2 text-xs font-bold text-slate-100 ring-1 ring-white/10">
                                    <span class="material-symbols-outlined text-[16px] text-red-300">school</span>
                                    {{ resume.education?.length ?? 0 }} estudios
                                </span>

                                <span
                                    class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-3 py-2 text-xs font-bold text-slate-100 ring-1 ring-white/10">
                                    <span class="material-symbols-outlined text-[16px] text-red-300">psychology</span>
                                    {{ resume.skills?.length ?? 0 }} habilidades
                                </span>

                                <span
                                    class="inline-flex items-center gap-2 rounded-2xl px-3 py-2 text-xs font-bold ring-1"
                                    :class="resume.pdf_path ? 'bg-green-500/15 text-green-100 ring-green-300/20' : 'bg-white/10 text-slate-100 ring-white/10'">
                                    <span class="material-symbols-outlined text-[16px]">attach_file</span>
                                    {{ resume.pdf_path ? 'PDF subido' : 'Sin PDF' }}
                                </span>
                            </div>
                        </div>

                        <div class="rounded-3xl bg-white/10 p-4 shadow-xl ring-1 ring-white/10 backdrop-blur">
                            <div class="space-y-3">
                                <Button :pt="ptButton"
                                    class="!w-full !rounded-2xl !border-red-600 !bg-red-600 !px-5 !py-3 !text-sm !font-black !text-white !shadow-lg !shadow-red-900/30 hover:!border-red-700 hover:!bg-red-700"
                                    label="Ver PDF generado"
                                    @click="openNewTab(route('candidato.resume.pdf.preview', resume.id))">
                                    <template #icon>
                                        <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                                    </template>
                                </Button>

                                <Button :pt="ptButton" outlined
                                    class="!w-full !rounded-2xl !border-white/15 !bg-white/10 !px-5 !py-3 !text-sm !font-bold !text-white hover:!bg-white/15"
                                    label="Editar currículum" @click="goTo(route('candidato.resume.edit', resume.id))">
                                    <template #icon>
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </template>
                                </Button>

                                <Button :pt="ptButton" outlined
                                    class="!w-full !rounded-2xl !border-red-300/20 !bg-red-500/10 !px-5 !py-3 !text-sm !font-bold !text-red-100 hover:!bg-red-500/20"
                                    label="Eliminar currículum" @click="deleteModal = true">
                                    <template #icon>
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </template>
                                </Button>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <!-- Columna principal -->
                    <div class="space-y-6 lg:col-span-2">
                        <!-- Resumen profesional -->
                        <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                            <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
                                <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                    Resumen profesional
                                </p>
                            </div>

                            <div class="px-6 py-6">
                                <p class="whitespace-pre-line text-sm leading-7 text-slate-600">
                                    {{ resume.summary || 'Sin resumen profesional registrado.' }}
                                </p>
                            </div>
                        </section>

                        <!-- Experiencia laboral -->
                        <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                            <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
                                <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                    Experiencia laboral
                                </p>
                            </div>

                            <div class="px-6 py-6">
                                <div v-if="resume.work_experience?.length" class="space-y-5">
                                    <div v-for="(exp, index) in resume.work_experience" :key="index"
                                        class="relative flex gap-4">
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="flex h-10 w-10 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                                                <span class="material-symbols-outlined text-[20px]">work</span>
                                            </div>

                                            <div v-if="index !== resume.work_experience.length - 1"
                                                class="mt-2 h-full w-px bg-slate-200"></div>
                                        </div>

                                        <div class="min-w-0 pb-2">
                                            <p class="font-black text-slate-900">
                                                {{ exp.position }}
                                            </p>

                                            <p class="mt-1 text-sm font-semibold text-slate-600">
                                                {{ exp.company }}
                                            </p>

                                            <p class="mt-1 text-xs font-medium text-slate-400">
                                                {{ formatDate(exp.start_date) }} —
                                                {{ exp.end_date ? formatDate(exp.end_date) : 'Actualidad' }}
                                            </p>

                                            <p v-if="exp.description"
                                                class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-500">
                                                {{ exp.description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <p v-else class="text-sm text-slate-400">
                                    Sin experiencia registrada.
                                </p>
                            </div>
                        </section>

                        <!-- Educación -->
                        <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                            <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
                                <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                    Educación
                                </p>
                            </div>

                            <div class="px-6 py-6">
                                <div v-if="resume.education?.length" class="space-y-4">
                                    <div v-for="(edu, index) in resume.education" :key="index"
                                        class="flex gap-4 rounded-2xl border border-slate-100 bg-slate-50 px-4 py-4">
                                        <div
                                            class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-2xl bg-white text-red-600 shadow-sm">
                                            <span class="material-symbols-outlined text-[20px]">school</span>
                                        </div>

                                        <div>
                                            <p class="font-black text-slate-900">
                                                {{ edu.title }}
                                            </p>

                                            <p class="mt-1 text-sm font-semibold text-slate-600">
                                                {{ edu.school }}
                                            </p>

                                            <p class="mt-1 text-xs font-medium text-slate-400">
                                                {{ edu.year }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <p v-else class="text-sm text-slate-400">
                                    Sin educación registrada.
                                </p>
                            </div>
                        </section>

                        <!-- PDF subido -->
                        <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                            <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
                                <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                    Hoja de vida subida
                                </p>

                                <h3 class="mt-2 text-xl font-black text-slate-950">
                                    Archivo PDF
                                </h3>
                            </div>

                            <div class="px-6 py-6">
                                <div v-if="resume.pdf_path">
                                    <div
                                        class="mb-5 flex flex-col gap-4 rounded-3xl border border-slate-200 bg-slate-50 p-4 sm:flex-row sm:items-center sm:justify-between">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                                                <span class="material-symbols-outlined">attach_file</span>
                                            </div>

                                            <div>
                                                <p class="text-sm font-black text-slate-800">
                                                    Archivo subido
                                                </p>

                                                <p class="mt-1 text-xs font-medium text-slate-400">
                                                    {{ resume.pdf_size ? formatSize(resume.pdf_size) : '' }}
                                                    {{ resume.pdf_mime ? ` · ${resume.pdf_mime}` : '' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex flex-wrap gap-2">
                                            <Button :pt="ptButton" outlined
                                                class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-xs !font-bold !text-slate-700 hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
                                                label="Abrir" @click="openNewTab(resume.pdf_url)">
                                                <template #icon>
                                                    <span
                                                        class="material-symbols-outlined text-[16px]">open_in_new</span>
                                                </template>
                                            </Button>

                                            <Button :pt="ptButton" outlined
                                                class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-xs !font-bold !text-slate-700 hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
                                                label="Descargar"
                                                @click="download(resume.pdf_url, `cv_${resume.id}.pdf`)">
                                                <template #icon>
                                                    <span class="material-symbols-outlined text-[16px]">download</span>
                                                </template>
                                            </Button>

                                            <Button :pt="ptButton" outlined
                                                class="!rounded-2xl !border-red-200 !bg-white !px-4 !py-2.5 !text-xs !font-bold !text-red-600 hover:!bg-red-50"
                                                :disabled="deletingPdf" :label="deletingPdf ? '...' : 'Eliminar'"
                                                @click="removePdf">
                                                <template #icon>
                                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                                </template>
                                            </Button>
                                        </div>
                                    </div>

                                    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-slate-50">
                                        <iframe :src="`${resume.pdf_url}#toolbar=1&navpanes=0`" class="w-full"
                                            style="height: 520px;" type="application/pdf">
                                            <div class="p-8 text-center">
                                                <p class="mb-3 text-sm text-slate-500">
                                                    Tu navegador no puede mostrar el PDF aquí.
                                                </p>

                                                <Button :pt="ptButton" label="Abrir PDF en nueva pestaña →"
                                                    @click="openNewTab(resume.pdf_url)" />
                                            </div>
                                        </iframe>
                                    </div>
                                </div>

                                <div v-else
                                    class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-slate-500 shadow-sm">
                                        <span class="material-symbols-outlined">upload_file</span>
                                    </div>

                                    <p class="mt-4 text-sm font-black text-slate-700">
                                        Sin PDF subido
                                    </p>

                                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                                        Puedes subir una hoja de vida en PDF desde la edición de tu currículum.
                                    </p>

                                    <Link :href="route('candidato.resume.edit', resume.id)"
                                        class="mt-5 inline-flex rounded-2xl bg-red-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-red-600/25 transition hover:bg-red-700">
                                        Editar currículum
                                    </Link>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Columna lateral -->
                    <aside class="space-y-6 lg:sticky lg:top-6 lg:self-start">
                        <!-- Habilidades -->
                        <section class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-400">
                                Habilidades
                            </p>

                            <div v-if="resume.skills?.length" class="mt-4 flex flex-wrap gap-2">
                                <Tag v-for="(skill, index) in resume.skills" :key="index" :pt="ptTag"
                                    class="!rounded-full !bg-red-50 !px-3 !py-1.5 !text-xs !font-bold !text-red-700">
                                    {{ skill }}
                                </Tag>
                            </div>

                            <p v-else class="mt-4 text-sm text-slate-400">
                                Sin habilidades.
                            </p>
                        </section>

                        <!-- Idiomas -->
                        <section class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-400">
                                Idiomas
                            </p>

                            <div v-if="resume.languages?.length" class="mt-4 space-y-3">
                                <div v-for="(lang, index) in resume.languages" :key="index"
                                    class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                    <span class="text-sm font-bold text-slate-700">
                                        {{ lang.name }}
                                    </span>

                                    <span class="rounded-full bg-slate-950 px-3 py-1 text-xs font-black text-white">
                                        {{ lang.level }}
                                    </span>
                                </div>
                            </div>

                            <p v-else class="mt-4 text-sm text-slate-400">
                                Sin idiomas.
                            </p>
                        </section>

                        <!-- Certificaciones -->
                        <section class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-400">
                                Certificaciones
                            </p>

                            <div v-if="resume.certifications?.length" class="mt-4 space-y-3">
                                <div v-for="(cert, index) in resume.certifications" :key="index"
                                    class="rounded-2xl bg-slate-50 px-4 py-3">
                                    <p class="text-sm font-black text-slate-800">
                                        {{ cert.name }}
                                    </p>

                                    <p class="mt-1 text-xs font-medium text-slate-400">
                                        {{ cert.institution }}
                                        <span v-if="cert.year"> · {{ cert.year }}</span>
                                    </p>
                                </div>
                            </div>

                            <p v-else class="mt-4 text-sm text-slate-400">
                                Sin certificaciones.
                            </p>
                        </section>

                        <!-- Zona de peligro -->
                        <section class="rounded-[2rem] border border-red-100 bg-red-50 p-5">
                            <p class="text-sm font-black text-red-700">
                                Zona de eliminación
                            </p>

                            <p class="mt-2 text-sm leading-6 text-red-700/80">
                                Si eliminas tu currículum, perderás la información registrada.
                            </p>

                            <Button :pt="ptButton" outlined
                                class="mt-4 !rounded-2xl !border-red-200 !bg-white !px-4 !py-2.5 !text-sm !font-bold !text-red-600 hover:!bg-red-100"
                                label="Eliminar currículum" @click="deleteModal = true">
                                <template #icon>
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </template>
                            </Button>
                        </section>
                    </aside>
                </div>

                <!-- Modal eliminar -->
                <Dialog v-model:visible="deleteModal" modal :draggable="false" class="w-full max-w-md" :pt="ptDialog">
                    <template #header>
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-red-600">
                                Confirmación
                            </p>

                            <h3 class="mt-1 text-lg font-black text-slate-950">
                                Eliminar currículum
                            </h3>
                        </div>
                    </template>

                    <p class="text-sm leading-6 text-slate-600">
                        ¿Seguro que deseas eliminar tu currículum? Esta acción no se puede deshacer y perderás toda la
                        información registrada.
                    </p>

                    <template #footer>
                        <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                            <Button :pt="ptButton" outlined
                                class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-sm !font-bold !text-slate-700 hover:!bg-slate-50"
                                label="Cancelar" @click="deleteModal = false" />

                            <Button :pt="ptButton"
                                class="!rounded-2xl !border-red-600 !bg-red-600 !px-4 !py-2.5 !text-sm !font-black !text-white hover:!border-red-700 hover:!bg-red-700"
                                :disabled="deleteForm.processing"
                                :label="deleteForm.processing ? 'Eliminando...' : 'Eliminar'" @click="doDelete" />
                        </div>
                    </template>
                </Dialog>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, useForm, router as inertiaRouter } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import Button from 'primevue/button';
import Tag from 'primevue/tag';
import Message from 'primevue/message';
import Dialog from 'primevue/dialog';

import { ptButton, ptTag, ptMessage } from '@/primevue/pt';

const props = defineProps({
    resume: { type: Object, required: true },
});

const deleteModal = ref(false);
const deletingPdf = ref(false);

const ptDialog = {
    root: () => ({
        class: 'overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-2xl',
    }),
    header: () => ({
        class: 'border-b border-slate-100 px-6 py-5',
    }),
    content: () => ({
        class: 'px-6 py-5',
    }),
    footer: () => ({
        class: 'border-t border-slate-100 px-6 py-5',
    }),
};

const deleteForm = useForm({});

function doDelete() {
    deleteForm.delete(route('candidato.resume.destroy', props.resume.id), {
        onSuccess: () => {
            deleteModal.value = false;
        },
    });
}

function removePdf() {
    deletingPdf.value = true;

    inertiaRouter.delete(route('candidato.resume.destroyPdf', props.resume.id), {
        preserveScroll: true,
        onFinish: () => {
            deletingPdf.value = false;
        },
    });
}

function goTo(href) {
    inertiaRouter.visit(href);
}

function openNewTab(url) {
    window.open(url, '_blank', 'noopener,noreferrer');
}

function download(url, filename) {
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    a.remove();
}

function formatDate(dateStr) {
    if (!dateStr) return '';

    const [year, month] = dateStr.split('-');
    const months = [
        'Ene',
        'Feb',
        'Mar',
        'Abr',
        'May',
        'Jun',
        'Jul',
        'Ago',
        'Sep',
        'Oct',
        'Nov',
        'Dic',
    ];

    return `${months[parseInt(month) - 1]} ${year}`;
}

function formatSize(bytes) {
    if (!bytes) return '';

    if (bytes < 1024) return `${bytes} B`;
    if (bytes < 1024 * 1024) return `${(bytes / 1024).toFixed(0)} KB`;

    return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
}
</script>

<style scoped>
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}
</style>