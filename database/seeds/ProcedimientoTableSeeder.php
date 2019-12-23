<?php

use Illuminate\Database\Seeder;
use App\Procedimiento;
class ProcedimientoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Procedimientos
    	Procedimiento::create([
    		'nombre' => 'Guardas Oclusales',
    		'descripcion' => 'Consiste en un aparato bucal de plastico que se coloca en una de las arcadas dentarias para evitar que entren en contacto unos dientes con otros, para llevar la mandibula a una posicion articularmente adecuada cuando se muerde sobre ella, bien para "olvidar" las posiciones mandibulares inadecuadas e incorrectas de los dientes cuando se mantienen apretados, o bien para evitar el desgaste de los dientes (bruxismo), ya que el plastico de la placa es mas blando y desgastable que estos.',
    	]);

		Procedimiento::create([
    		'nombre' => 'Protesis Completa',
    		'descripcion' => 'Protesis que se realizan cuando el paciente no tiene ningún diente, y son por tanto mucosoportadas, al carecer de pilares para la sujeción. El soporte de la prótesis se toma a partir de unas anchas bases, que se extienden sobre la superficie de la mucosa en los procesos alveolares.',
    	]);

    	Procedimiento::create([
    		'nombre' => 'Protesis Parciales Fijas',
    		'descripcion' => 'Protesis completamente dentosoportadas, que toman apoyo unicamente en los dientes.',
    	]);

    	Procedimiento::create([
    		'nombre' => 'Protesis Removibles Parciales y Totales',
    		'descripcion' => 'Tratamiento de Odontologia restauradora que, como su propio nombre indica, se diseñan y fabrican de modo que el paciente pueda colocarsela y quitarsela cuando lo necesite, lo que facilita enormemente su higiene.',
    	]);

		Procedimiento::create([
    		'nombre' => 'Protesis Valplast',
    		'descripcion' => 'tambien conocidas como las prótesis dentales flexibles hacen referencia a un tipo de prótesis removible, es decir, de quitar y poner, y confeccionadas por un material flexible conocido como Nylon. ',
		]);
		
		Procedimiento::create([
    		'nombre' => 'Protesis Wipla',
    		'descripcion' => 'Una prótesis dental removible es una estructura metálica con varios dientes artificiales fijados en sus laterales. Para ofrecer una mejor fijación, las prótesis dentales removibles se anclan a los dientes que el paciente aún conserva en su boca mediante unas sujeciones metálicas.',
		]);
		
		Procedimiento::create([
    		'nombre' => 'Implantes',
    		'descripcion' => 'El implante dental es un producto sanitario diseñado para sustituir la raíz que falta y mantener el diente artificial en su sitio. ',
		]);
		
		Procedimiento::create([
    		'nombre' => 'Coronas Esteticas',
    		'descripcion' => 'Comúnmente llamada funda, es la construcción protésica cuyo objetivo consiste en cubrir un elemento dentario que tiene la raíz en el interior del hueso sano, mientras que una parte del exterior se encuentra considerablemente destruida por patologías como la caries',
		]);
		
		Procedimiento::create([
    		'nombre' => 'Provisionales',
    		'descripcion' => 'Protesis provisionales, tienen la funcion de proteger la sensibilidad a cambios termicos y la elongacion o migracion de dientes',
    	]);

		Procedimiento::create([
    		'nombre' => 'Recubrimiento Pulpar',
    		'descripcion' => 'El recubrimiento pulpar es un procedimiento de endodoncia que se realiza con fines preventivos para evitar lesiones irreversibles de la pulpa así como preservar la vitalidad pulpar cuando se ve afectada por una inflamación o una infección.',
    	]);

		Procedimiento::create([
    		'nombre' => 'Obturaciones Esteticas (Rellenos)',
    		'descripcion' => 'Limpiar la cavidad resultante de una caries para luego rellenarla con algún material.',
		]);
		
		Procedimiento::create([
    		'nombre' => 'Pines de Fibra',
    		'descripcion' => 'Los postes de endodoncia son pequeños pilares de solo unos milímetros de largo que los odontólogos colocan en el conducto de la raíz o raíces de un diente que ha sido endodonciado. ',
		]);
		
		Procedimiento::create([
    		'nombre' => 'Reconstrucciones',
    		'descripcion' => 'La reconstrucción dental es uno de los procedimientos más frecuentes de cuantos se realizan en odontología y puede implicar la reparación del diente o su sustitución, con el objetivo de mantener la dentadura completa y toda su funcionalidad.',
		]);
		
		Procedimiento::create([
    		'nombre' => 'Laminados',
    		'descripcion' => 'Una especie de capa externa para los dientes que consigue un acabado natural y una estética dental idéntica o superior al diente natural.',
		]);
		
		Procedimiento::create([
    		'nombre' => 'Incrustaciones',
    		'descripcion' => 'Este tratamiento está indicado para la restauración dentaria en dientes posteriores (Molares y Premolares) que sufran de caries de leves a moderadas y también en casos de fracturas o fisuras siempre que el daño no sea tan importante como para indicar una corona.',
		]);
		
		Procedimiento::create([
    		'nombre' => 'Sellante de fosas y Fisuras',
    		'descripcion' => 'Los selladores son sustancias químicas que actúan como barrera física impidiendo que las bacterias y restos de alimentos penetren en las fosas y fisuras y evitando la aparición de caries producida por las bacterias.',
    	]);

    	Procedimiento::create([
    		'nombre' => 'Profilaxis',
    		'descripcion' => 'La profilaxis o limpieza dental consiste en la remoción de placa bacteriana y cálculos de sarro formados alrededor de los dientes, este tratamiento puede realizarse según el caso, con instrumentos manuales con ultrasonido u otro instrumento electromecánico.',
		]);
		
		Procedimiento::create([
    		'nombre' => 'Detartrajes',
    		'descripcion' => 'El detartraje supragingival es una técnica de limpieza bucal especial que debe ser realizada por un profesional. Consiste en remover los cálculos de las superficies dentales, es decir, la placa bacteriana y el sarro acumulados en las encías.',
		]);
		
		Procedimiento::create([
    		'nombre' => 'Alisado Radicular',
    		'descripcion' => 'El alisado radicular es un tratamiento mecánico de la superficie de la raíz del diente, es un tratamiento indicado para pacientes con periodontitis.',
		]);
		
		Procedimiento::create([
    		'nombre' => 'Blanqueamiento Dental',
    		'descripcion' => 'El blanqueamiento dental es un procedimiento clínico que trata de conseguir el aclaramiento del color de uno o varios dientes aplicando un agente químico, y tratando de no alterar su estructura básica.',
		]);

		Procedimiento::create([
    		'nombre' => 'Endodoncia monoradicular',
    		'descripcion' => 'Extirpacion de la pulpa dental y el posterior relleno y sellado de la cavidad pulpar con un material inerte.',
    	]);


    	Procedimiento::create([
    		'nombre' => 'Endodoncia multiradicular',
    		'descripcion' => 'Extirpacion de la pulpa dental En los molares, podemos encontrar tres o más conductos. En estos casos, además tenemos un peor acceso para trabajar debido a su posición más posterior en la boca, por lo que las sesiones de trabajo son algo más largas que en el resto.',
		]);
		
		Procedimiento::create([
    		'nombre' => 'Pulpotomia',
    		'descripcion' => 'Pulpotomía es la extirpación quirúrgica de la pulpa inflamada, debido al ataque de algunas bacterias en el diente.',
		]);
		
		Procedimiento::create([
    		'nombre' => 'Pulpectomia',
    		'descripcion' => 'La pulpectomía es un procedimiento que se realiza en dientes con caries importantes.',
    	]);

		Procedimiento::create([
    		'nombre' => 'Retratamientos Endodonticos',
    		'descripcion' => 'Consiste en la eliminación de material existente, nueva limpieza y conformación del conducto, suele realizarse cuando el tratamiento inicial es inadecuado o ha fracasado o el conducto se ve contaminado nuevamente por una exposición prolongada con el medio oral.',
    	]);
		
		Procedimiento::create([
    		'nombre' => 'Cirugia de Cordales impactadas, retenidas y/o enclavadas',
    		'descripcion' => 'se realiza en los casos en los que dan sintomatologia (dolor grave o agudo, infecciones de repeticion, caries en los segundos molares por mala higiene, etc.) o se encuentra algun signo radiologico patologico (algun quiste o erosión de raices de otras piezas).',
		]);
		
		Procedimiento::create([
    		'nombre' => 'Apicectomia endodontica',
    		'descripcion' => 'Es un procedimiento quirúrgico cuyo objetivo es eliminar una infección que afecta a la raíz de una pieza dental y a los tejidos adyacentes.',
		]);
		
		Procedimiento::create([
    		'nombre' => 'Frenectomia',
    		'descripcion' => 'La frenilectomía es un procedimiento quirúrgico odontológico por el cual se elimina una brida o frenillo que une la lengua o el labio inferior a la encía, afectando a la posición dentaria, protésica o a la movilidad lingual o labial.',
		]);
		
		Procedimiento::create([
    		'nombre' => 'Rescate de caninos retenidos',
    		'descripcion' => 'La retención, es decir, la no erupción de un diente permanente más allá de un año después de la edad normal de erupción, es relativamente poco frecuente si exceptuamos el caso de los terceros molares y los caninos superiores.',
		]);

		Procedimiento::create([
    		'nombre' => 'Extraccion de supernumerarios',
    		'descripcion' => 'Un diente supernumerario es un germen dentario de más que aparecen de forma adicional al número de piezas de la dotación dental normal, excediendo el número de dientes de la arcada maxilar o mandibular.',
		]);

		Procedimiento::create([
    		'nombre' => 'Frenoplastias',
    		'descripcion' => 'Una frenuloplasty es la alteración quirúrgica de un frenillo cuando su presencia restringe la amplitud del movimiento entre tejidos interconectados.',
		]);

		Procedimiento::create([
    		'nombre' => 'Gingivectomias',
    		'descripcion' => 'La gingivectomía es un procedimiento quirúrgico por el que se extirpa una parte lesionada de la encía (tejido gingival) para eliminar o reducir una bolsa periodontal, es decir, el espacio que se forma entre la encía y el diente como consecuencia de la acumulación de placa bacteriana bajo de la encía',
		]);

		Procedimiento::create([
    		'nombre' => 'Gingivoplastias',
    		'descripcion' => 'La gingivoplastia es un procedimiento similar al de la gingivectomía pero se emplea con un fin diferente, ya que su propósito es el de volver a contornear la encía en ausencia de bolsas, buscando devolverle su arquitectura y fisiología normales.',
		]);

		Procedimiento::create([
    		'nombre' => 'Exodoncia o extraccion complicada',
    		'descripcion' => 'Las exodoncias complejas son aquellas que presentan una dificultad que convierte una exodoncia convencional en una extracción con exigencia de medios especiales técnicos, médicos, farmacológicos o de cualquier otro tipo, y en la mayoría de los casos se traduce en la existencia de realizar una exodoncia quirúrgica.',
		]);

		Procedimiento::create([
    		'nombre' => 'Exodoncia o extraccion de resto radicular',
    		'descripcion' => 'No Disponible',
		]);

		Procedimiento::create([
    		'nombre' => 'Exodoncia o Extraccion Simple',
    		'descripcion' => 'La exodoncia es una intervención quirúrgica dentro de la odontología que consiste en la extracción de un diente. Esta operación se realiza bajo anestesia y no conlleva grandes peligros salvo leves infecciones que ocurren con poca frecuencia.',
		]);

		Procedimiento::create([
    		'nombre' => 'Cirugia periodontal',
    		'descripcion' => 'La cirugía periodontal es un tratamiento necesario en muchos pacientes que sufren periodontitis, la fase crónica de la enfermedad de las encías. La periodontitis es una infección bacteriana que destruye poco a poco el tejido que sostiene a los dientes: las encías, pero también el hueso y el ligamento periodontal.',
		]);

		Procedimiento::create([
    		'nombre' => 'Alargamiento de corona',
    		'descripcion' => 'El alargamiento de corona es un procedimiento quirúrgico cuya función es la remodelación del contorno de los tejidos de la encía y, a menudo, del hueso subyacente, alrededor de uno o más dientes para que quede expuesta la suficiente de la pieza dental.',
		]);

		Procedimiento::create([
    		'nombre' => 'Cirugia de mucocele labial',
    		'descripcion' => 'Los mucoceles son lesiones que se manifiestan en la mucosa oral como consecuencia de una alteración en los conductos de las glándulas salivales menores, caracterizados por el cúmulo de material mucoide, bien porque se ha extravasado del conducto del conducto excretor, bien porque se ha retenido en este conducto, que presenta una dilatación muy importante.',
		]);

    	Procedimiento::create([
    		'nombre' => 'Otros',
    		'descripcion' => 'No Disponible',
		]);
    }
}
