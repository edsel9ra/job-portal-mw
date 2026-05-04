<template>
    <AuthenticatedLayout>
        <template #header>
            <div>
                <!--<p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                    Perfil del candidato
                </p>-->

                <h2 class="mt-1 text-xl font-black uppercase tracking-tight text-slate-950">
                    Completar perfil
                </h2>
            </div>
        </template>

        <div class="relative overflow-hidden px-8 py-8">
            <div class="pointer-events-none absolute left-[-160px] top-0 h-80 w-80 rounded-full bg-red-500/10 blur-3xl">
            </div>
            <div
                class="pointer-events-none absolute right-[-180px] top-40 h-96 w-96 rounded-full bg-blue-700/10 blur-3xl">
            </div>

            <div class="relative mx-auto max-w-6xl space-y-6">
                <!-- Hero -->
                <section
                    class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 p-6 text-white shadow-2xl shadow-slate-300/60 sm:p-8">
                    <div
                        class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-red-600/30 blur-3xl">
                    </div>
                    <div
                        class="pointer-events-none absolute -bottom-24 left-10 h-72 w-72 rounded-full bg-blue-600/20 blur-3xl">
                    </div>

                    <div class="relative grid gap-6 lg:grid-cols-[1fr_340px] lg:items-center">
                        <div>
                            <div
                                class="mb-5 inline-flex rounded-full bg-red-600/20 px-4 py-2 text-xs font-black uppercase tracking-[0.22em] text-red-100 ring-1 ring-red-400/20">
                                Primer paso
                            </div>

                            <h1 class="max-w-3xl text-3xl font-black leading-tight tracking-tight sm:text-4xl">
                                Completa tu información personal para continuar.
                            </h1>

                            <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-300">
                                Esta información nos ayuda a identificar tu perfil como candidato y habilitar correctamente tu proceso de postulación.
                            </p>
                        </div>

                        <div class="rounded-3xl bg-white/10 p-5 shadow-xl ring-1 ring-white/10 backdrop-blur">
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-600 text-white shadow-lg shadow-red-900/30">
                                    <span class="material-symbols-outlined">person_add</span>
                                </div>

                                <div>
                                    <p class="text-sm font-black text-white">
                                        Perfil requerido
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-300">
                                        Debes completar estos datos antes de avanzar dentro del portal.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Formulario -->
                <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
                        <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                            Información personal
                        </p>

                        <h3 class="mt-2 text-xl font-black text-slate-950">
                            Datos básicos del candidato
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Ingresa la información solicitada y guarda tu perfil.
                        </p>
                    </div>

                    <form class="p-6" @submit.prevent="submit">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Tipo documento -->
                            <div>
                                <label class="mb-2 block text-sm font-black text-slate-800">
                                    Tipo de documento
                                </label>

                                <select v-model="form.document_type"
                                    class="block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 shadow-sm outline-none transition focus:border-red-500 focus:bg-white focus:ring-4 focus:ring-red-500/20">
                                    <option value="">Selecciona una opción</option>
                                    <option value="CC">Cédula de ciudadanía (CC)</option>
                                    <option value="CE">Cédula de extranjería (CE)</option>
                                    <option value="TI">Tarjeta de identidad (TI)</option>
                                    <option value="Pasaporte">Pasaporte</option>
                                    <option value="PT">Permiso temporal (PT)</option>
                                </select>

                                <p v-if="form.errors.document_type" class="mt-2 text-xs font-semibold text-red-500">
                                    {{ form.errors.document_type }}
                                </p>
                            </div>

                            <!-- Número documento -->
                            <div>
                                <label class="mb-2 block text-sm font-black text-slate-800">
                                    Número de documento
                                </label>

                                <input v-model="form.document_number" type="text"
                                    class="block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:bg-white focus:ring-4 focus:ring-red-500/20"
                                    placeholder="Ej: 123456789" />

                                <p v-if="form.errors.document_number" class="mt-2 text-xs font-semibold text-red-500">
                                    {{ form.errors.document_number }}
                                </p>
                            </div>

                            <!-- Celular -->
                            <div>
                                <label class="mb-2 block text-sm font-black text-slate-800">
                                    Celular
                                </label>

                                <input v-model="form.phone" type="text"
                                    class="block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:bg-white focus:ring-4 focus:ring-red-500/20"
                                    placeholder="Ej: 300 000 0000" />

                                <p v-if="form.errors.phone" class="mt-2 text-xs font-semibold text-red-500">
                                    {{ form.errors.phone }}
                                </p>
                            </div>

                            <!-- Fecha nacimiento -->
                            <div>
                                <label class="mb-2 block text-sm font-black text-slate-800">
                                    Fecha de nacimiento
                                </label>

                                <input v-model="form.birth_date" type="date"
                                    class="block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 shadow-sm outline-none transition focus:border-red-500 focus:bg-white focus:ring-4 focus:ring-red-500/20" />

                                <p v-if="form.errors.birth_date" class="mt-2 text-xs font-semibold text-red-500">
                                    {{ form.errors.birth_date }}
                                </p>
                            </div>

                            <!-- Ciudad -->
                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-black text-slate-800">
                                    Ciudad
                                </label>

                                <input v-model="form.city" type="text"
                                    class="block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:bg-white focus:ring-4 focus:ring-red-500/20"
                                    placeholder="Ej: Cali" />

                                <p v-if="form.errors.city" class="mt-2 text-xs font-semibold text-red-500">
                                    {{ form.errors.city }}
                                </p>
                            </div>

                            <!-- Foto -->
                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-black text-slate-800">
                                    Foto de perfil
                                </label>

                                <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-5">
                                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                                        <div
                                            class="flex h-24 w-24 flex-shrink-0 items-center justify-center overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
                                            <img v-if="previewPhoto || candidate?.photo"
                                                :src="previewPhoto || `/storage/${candidate.photo}`"
                                                alt="Foto de perfil" class="h-full w-full object-cover" />

                                            <span v-else class="material-symbols-outlined text-[38px] text-slate-400">
                                                person
                                            </span>
                                        </div>

                                        <div class="min-w-0 flex-1">
                                            <input type="file" accept="image/*"
                                                class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-600 shadow-sm file:mr-4 file:rounded-xl file:border-0 file:bg-red-50 file:px-4 file:py-2 file:text-sm file:font-bold file:text-red-600 hover:file:bg-red-100"
                                                @change="handleFile" />

                                            <p class="mt-2 text-xs leading-5 text-slate-400">
                                                Sube una imagen clara. Formatos recomendados: JPG, PNG o WEBP.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <p v-if="form.errors.photo" class="mt-2 text-xs font-semibold text-red-500">
                                    {{ form.errors.photo }}
                                </p>
                            </div>
                        </div>

                        <!-- Botón -->
                        <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-2xl bg-red-600 px-6 py-3 text-sm font-black text-white shadow-lg shadow-red-600/25 transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-60"
                                :disabled="form.processing">
                                <span v-if="form.processing"
                                    class="mr-2 h-4 w-4 animate-spin rounded-full border-2 border-white/30 border-t-white"></span>
                                {{ form.processing ? 'Guardando...' : 'Guardar perfil' }}
                            </button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    candidate: {
        type: Object,
        default: null,
    },
});

const previewPhoto = ref(null);

const form = useForm({
    document_type: props.candidate?.document_type ?? '',
    document_number: props.candidate?.document_number ?? '',
    phone: props.candidate?.phone ?? '',
    birth_date: props.candidate?.birth_date ?? '',
    city: props.candidate?.city ?? '',
    photo: null,
});

function handleFile(event) {
    const file = event.target.files?.[0] ?? null;

    form.photo = file;

    if (previewPhoto.value) {
        URL.revokeObjectURL(previewPhoto.value);
    }

    previewPhoto.value = file ? URL.createObjectURL(file) : null;
}

function submit() {
    form.post(route('candidato.profile.store'), {
        forceFormData: true,
    });
}
</script>

<style scoped>
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}
</style>
