<template>
  <AuthenticatedLayout>
    <template #header>
      <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <!--<p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
            Portal del candidato
          </p>-->
          <h2 class="mt-1 text-xl font-black uppercase tracking-tight text-slate-950">
            Panel de {{ user?.name }}
          </h2>
        </div>

        <!--<Button :pt="ptButton" outlined
          class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-sm !font-bold !text-slate-700 !shadow-sm hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
          label="Ver ofertas" @click="go(offersLink)">
          <template #icon>
            <span class="material-symbols-outlined text-[18px]">search</span>
          </template>
        </Button>-->
      </div>
    </template>

    <div class="relative overflow-hidden px-4 py-8">
      <!-- Fondos decorativos -->
      <div class="pointer-events-none absolute left-[-160px] top-0 h-80 w-80 rounded-full bg-red-500/10 blur-3xl"></div>
      <div class="pointer-events-none absolute right-[-180px] top-40 h-96 w-96 rounded-full bg-blue-700/10 blur-3xl">
      </div>

      <div class="relative mx-auto max-w-6xl space-y-6">
        <!-- Flash success -->
        <Message v-if="$page.props.flash?.success" :pt="ptMessage" severity="success" :closable="false"
          class="!rounded-2xl !border !border-green-200 !bg-green-50 !text-green-700">
          {{ $page.props.flash.success }}
        </Message>

        <!-- HERO -->
        <Card :pt="ptCard" class="overflow-hidden">
          <template #content>
            <div
              class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 p-6 text-white sm:p-8">
              <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-red-600/30 blur-3xl">
              </div>
              <div
                class="pointer-events-none absolute -bottom-24 left-10 h-72 w-72 rounded-full bg-blue-600/20 blur-3xl">
              </div>

              <div class="relative flex flex-col gap-7 lg:flex-row lg:items-start lg:justify-between">
                <div class="min-w-0">
                  <div
                    class="mb-5 inline-flex rounded-full bg-red-600/20 px-4 py-2 text-xs font-black uppercase tracking-[0.22em] text-red-100 ring-1 ring-red-400/20">
                    Bienvenido/a
                  </div>

                  <h1 class="max-w-3xl truncate text-3xl font-black tracking-tight text-white sm:text-4xl">
                    Hola, {{ user?.name }} 👋
                  </h1>

                  <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-300">
                    Aquí tienes un resumen rápido de tu actividad, el estado de tu currículum y tus siguientes pasos
                    dentro del portal.
                  </p>

                  <!-- Chips estado -->
                  <!--<div class="mt-5 flex flex-wrap gap-2">
                    <div
                      class="inline-flex items-center rounded-2xl bg-white/10 px-4 py-2 text-sm font-semibold text-slate-100 ring-1 ring-white/10">
                      <span class="material-symbols-outlined mr-2 text-[18px] text-red-300">description</span>
                      <span>Currículum:&nbsp;</span>
                      <b>{{ tieneCurriculum ? 'Listo' : 'Pendiente' }}</b>
                    </div>

                    <div
                      class="inline-flex items-center rounded-2xl bg-white/10 px-4 py-2 text-sm font-semibold text-slate-100 ring-1 ring-white/10">
                      <span class="material-symbols-outlined mr-2 text-[18px] text-red-300">send</span>
                      <span>Aplicaciones:&nbsp;</span>
                      <b>{{ aplicaciones }}</b>
                    </div>
                  </div>-->

                  <!-- Progreso perfil -->
                  <div class="mt-6 max-w-md">
                    <div class="mb-2 flex items-center justify-between text-xs text-slate-300">
                      <span class="font-semibold">Progreso del perfil</span>
                      <span class="font-black text-white">{{ profileProgress }}%</span>
                    </div>

                    <ProgressBar :pt="ptProgressHero" />
                  </div>
                </div>

                <!-- CTA -->
                <div
                  class="w-full rounded-3xl bg-white/10 p-4 shadow-xl ring-1 ring-white/10 backdrop-blur lg:w-[300px]">
                  <div class="space-y-3">
                    <Button :pt="ptButton"
                      class="!w-full !rounded-2xl !border-red-600 !bg-red-600 !px-5 !py-3 !text-sm !font-black !text-white !shadow-lg !shadow-red-900/30 hover:!border-red-700 hover:!bg-red-700"
                      :label="tieneCurriculum ? 'Actualizar currículum' : 'Crear currículum'" @click="go(resumeLink)">
                      <template #icon>
                        <span class="material-symbols-outlined text-[18px]">edit_document</span>
                      </template>
                    </Button>

                    <Button v-if="tieneCurriculum" :pt="ptButton"
                      class="!w-full !rounded-2xl !border-white/15 !bg-white/10 !px-5 !py-3 !text-sm !font-bold !text-white hover:!bg-white/15"
                      label="Ver currículum" outlined @click="go(resumeShowLink)">
                      <template #icon>
                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                      </template>
                    </Button>

                    <Button :pt="ptButton"
                      class="!w-full !rounded-2xl !border-white/15 !bg-white/10 !px-5 !py-3 !text-sm !font-bold !text-white hover:!bg-white/15"
                      label="Buscar ofertas" outlined @click="go(offersLink)">
                      <template #icon>
                        <span class="material-symbols-outlined text-[18px]">search</span>
                      </template>
                    </Button>
                  </div>
                </div>
              </div>
            </div>

            <!-- ALERTA si no tiene CV -->
            <div v-if="!tieneCurriculum" class="border-t border-amber-100 bg-amber-50 px-6 py-5 sm:px-8">
              <div
                class="flex flex-col gap-4 rounded-2xl border border-amber-200 bg-white p-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex gap-3">
                  <div
                    class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-2xl bg-amber-100 text-amber-700">
                    <span class="material-symbols-outlined">warning</span>
                  </div>

                  <div>
                    <p class="text-sm font-black text-amber-900">
                      Aún no has creado tu currículum
                    </p>
                    <p class="mt-1 text-xs leading-5 text-amber-700">
                      Necesitas un currículum registrado para poder aplicar a las ofertas disponibles.
                    </p>
                  </div>
                </div>

                <Button :pt="ptButton"
                  class="!rounded-2xl !border-amber-900 !bg-amber-900 !px-4 !py-2.5 !text-sm !font-black !text-white hover:!border-amber-950 hover:!bg-amber-950"
                  label="Crear ahora" @click="go(resumeLink)" />
              </div>
            </div>
          </template>
        </Card>

        <!-- MÉTRICAS -->
        <section class="grid grid-cols-1 gap-4 md:grid-cols-3">
          <!-- Aplicaciones -->
          <Card :pt="ptCard"
            class="transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/80">
            <template #content>
              <div class="p-5">
                <div class="flex items-start justify-between gap-4">
                  <div>
                    <p class="text-sm font-bold text-slate-500">
                      Aplicaciones enviadas
                    </p>
                    <p class="mt-3 text-4xl font-black text-slate-950">
                      {{ aplicaciones }}
                    </p>
                  </div>

                  <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                    <span class="material-symbols-outlined">send</span>
                  </div>
                </div>

                <Button v-if="routeExists('candidato.applications.index')" :pt="ptButton" outlined
                  class="mt-5 !rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-xs !font-bold !text-slate-700 hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
                  label="Ver mis aplicaciones" @click="go(route('candidato.applications.index'))" />

                <p v-else class="mt-5 text-xs font-medium text-slate-400">
                  Postulaciones realizadas
                </p>
              </div>
            </template>
          </Card>

          <!-- Currículum -->
          <Card :pt="ptCard"
            class="transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/80">
            <template #content>
              <div class="p-5">
                <div class="flex items-start justify-between gap-4">
                  <div>
                    <p class="text-sm font-bold text-slate-500">
                      Currículum
                    </p>

                    <p class="mt-3 text-lg font-black" :class="tieneCurriculum ? 'text-slate-950' : 'text-slate-400'">
                      {{ tieneCurriculum ? 'Completado' : 'Sin completar' }}
                    </p>
                  </div>

                  <div class="flex h-12 w-12 items-center justify-center rounded-2xl"
                    :class="tieneCurriculum ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500'">
                    <span class="material-symbols-outlined">
                      {{ tieneCurriculum ? 'check_circle' : 'description' }}
                    </span>
                  </div>
                </div>

                <Button :pt="ptButton" outlined
                  class="mt-5 !rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-xs !font-bold !text-slate-700 hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
                  :label="tieneCurriculum ? 'Editar currículum' : 'Crear currículum'" @click="go(resumeLink)" />
              </div>
            </template>
          </Card>

          <!-- Siguiente paso -->
          <Card :pt="ptCard"
            class="transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/80">
            <template #content>
              <div class="p-5">
                <div class="flex items-start justify-between gap-4">
                  <div>
                    <p class="text-sm font-bold text-slate-500">
                      Siguiente paso
                    </p>

                    <p class="mt-3 text-lg font-black text-slate-950">
                      Continúa tu proceso
                    </p>
                  </div>

                  <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-950 text-white">
                    <span class="material-symbols-outlined">checklist</span>
                  </div>
                </div>

                <div class="mt-5 space-y-3 text-sm">
                  <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                    <span class="font-semibold text-slate-700">Completar currículum</span>
                    <span class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-black"
                      :class="tieneCurriculum ? 'bg-green-100 text-green-700' : 'bg-slate-200 text-slate-500'">
                      {{ tieneCurriculum ? '✓' : '—' }}
                    </span>
                  </div>

                  <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                    <span :class="tieneCurriculum ? 'font-semibold text-slate-700' : 'font-semibold text-slate-400'">
                      Enviar primera aplicación
                    </span>

                    <span class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-black"
                      :class="aplicaciones > 0 ? 'bg-green-100 text-green-700' : 'bg-slate-200 text-slate-500'">
                      {{ aplicaciones > 0 ? '✓' : '—' }}
                    </span>
                  </div>

                  <div class="pt-1">
                    <Button v-if="tieneCurriculum && aplicaciones === 0" :pt="ptButton" outlined
                      class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-xs !font-bold !text-slate-700 hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
                      label="Buscar ofertas" @click="go(offersLink)">
                      <template #icon>
                        <span class="material-symbols-outlined text-[16px]">search</span>
                      </template>
                    </Button>

                    <Button v-else-if="!tieneCurriculum" :pt="ptButton" outlined
                      class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-xs !font-bold !text-slate-700 hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
                      label="Crear currículum" @click="go(resumeLink)">
                      <template #icon>
                        <span class="material-symbols-outlined text-[16px]">edit_document</span>
                      </template>
                    </Button>
                  </div>
                </div>
              </div>
            </template>
          </Card>
        </section>

        <!-- ACCIONES RÁPIDAS -->
        <!--<Card :pt="ptCard">
          <template #content>
            <div class="p-6">
              <div class="mb-5 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <div>
                  <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                    Acciones rápidas
                  </p>
                  <h3 class="mt-1 text-lg font-black text-slate-950">
                    ¿Qué quieres hacer ahora?
                  </h3>
                </div>
              </div>

              <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <button type="button"
                  class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 p-5 text-left text-white shadow-xl shadow-slate-300/60 transition duration-300 hover:-translate-y-1"
                  @click="go(offersLink)">
                  <div
                    class="pointer-events-none absolute -right-12 -top-12 h-32 w-32 rounded-full bg-red-600/30 blur-2xl">
                  </div>

                  <div class="relative flex items-center gap-4">
                    <div
                      class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 ring-1 ring-white/10">
                      <span class="material-symbols-outlined text-[30px]">search</span>
                    </div>

                    <div class="min-w-0">
                      <p class="text-sm font-black">Buscar ofertas</p>
                      <p class="mt-1 text-xs leading-5 text-slate-300">
                        Explora vacantes disponibles y encuentra una oportunidad para ti.
                      </p>
                    </div>

                    <span class="material-symbols-outlined ml-auto text-slate-300 transition group-hover:translate-x-1">
                      arrow_forward
                    </span>
                  </div>
                </button>

                <button type="button"
                  class="group rounded-3xl border border-slate-200 bg-white p-5 text-left shadow-sm transition duration-300 hover:-translate-y-1 hover:border-red-200 hover:shadow-xl hover:shadow-slate-200/80"
                  @click="go(resumeLink)">
                  <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                      <span class="material-symbols-outlined text-[30px]">description</span>
                    </div>

                    <div class="min-w-0">
                      <p class="text-sm font-black text-slate-950">
                        {{ tieneCurriculum ? 'Actualizar currículum' : 'Crear currículum' }}
                      </p>

                      <p class="mt-1 text-xs leading-5 text-slate-500">
                        {{ tieneCurriculum ? 'Mantén tu perfil actualizado para nuevas oportunidades.' : 'Completa tu perfil profesional para poder aplicar.' }}
                      </p>
                    </div>

                    <span
                      class="material-symbols-outlined ml-auto text-slate-400 transition group-hover:translate-x-1 group-hover:text-red-600">
                      arrow_forward
                    </span>
                  </div>
                </button>
              </div>
            </div>
          </template>
        </Card>-->
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// PrimeVue
import Button from 'primevue/button';
import Message from 'primevue/message';
import Card from 'primevue/card';
import ProgressBar from 'primevue/progressbar';

// PT presets
import { ptButton, ptMessage } from '@/primevue/pt';

const props = defineProps({
  aplicaciones: { type: Number, default: 0 },
  tieneCurriculum: { type: Boolean, default: false },
  resumeId: { type: [Number, null], default: null },
});

const user = computed(() => usePage().props.auth.user);

function routeExists(name) {
  try {
    route(name);
    return true;
  } catch {
    return false;
  }
}

function go(href) {
  router.visit(href);
}

// Links
const resumeShowLink = computed(() => {
  if (routeExists('candidato.resume.show')) return route('candidato.resume.show');
  return props.resumeId ? route('candidato.resume.edit', props.resumeId) : route('candidato.resume.create');
});

const resumeLink = computed(() => {
  if (!props.tieneCurriculum) return route('candidato.resume.create');
  return props.resumeId ? route('candidato.resume.edit', props.resumeId) : resumeShowLink.value;
});

const offersLink = computed(() => {
  if (routeExists('candidato.jobs.index')) return route('candidato.jobs.index');
  if (routeExists('ofertas.index')) return route('ofertas.index');
  return '/ofertas';
});

// Progreso perfil
const profileProgress = computed(() => {
  let progress = 0;

  if (props.tieneCurriculum) progress += 50;
  if (props.aplicaciones > 0) progress += 50;

  return progress;
});

const ptCard = {
  root: () => ({
    class: 'rounded-[2rem] border border-slate-200 bg-white shadow-sm overflow-hidden',
  }),
  body: () => ({ class: 'p-0' }),
  content: () => ({ class: 'p-0' }),
};

const ptProgressHero = {
  root: () => ({
    class: 'h-2.5 rounded-full bg-white/15 overflow-hidden',
  }),
  value: () => ({
    class: 'h-2.5 rounded-full bg-red-500',
  }),
};
</script>

<style scoped>
.material-symbols-outlined {
  font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}
</style>