<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $nombre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ElementoPP> $elementos
 * @property-read int|null $elementos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Programa> $programas
 * @property-read int|null $programas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Area newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Area newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Area query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Area whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Area whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Area whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Area whereUpdatedAt($value)
 */
	class Area extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property string|null $img_url
 * @property int $cantidad
 * @property string|null $talla
 * @property int|null $areas_id
 * @property int|null $filtros_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Area|null $area
 * @property-read \App\Models\Filtro|null $filtro
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pedido> $pedidos
 * @property-read int|null $pedidos_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoPP newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoPP newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoPP query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoPP whereAreasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoPP whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoPP whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoPP whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoPP whereFiltrosId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoPP whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoPP whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoPP whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoPP whereTalla($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoPP whereUpdatedAt($value)
 */
	class ElementoPP extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $pedidos_id
 * @property int $elementos_pp_id
 * @property int $cantidad
 * @property string|null $talla
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoXPedido newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoXPedido newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoXPedido query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoXPedido whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoXPedido whereElementosPpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoXPedido whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoXPedido wherePedidosId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ElementoXPedido whereTalla($value)
 */
	class ElementoXPedido extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $numero
 * @property int|null $programas_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pedido> $pedidos
 * @property-read int|null $pedidos_count
 * @property-read \App\Models\Programa|null $programa
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ficha newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ficha newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ficha query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ficha whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ficha whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ficha whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ficha whereProgramasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ficha whereUpdatedAt($value)
 */
	class Ficha extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $parte_del_cuerpo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ElementoPP> $elementos
 * @property-read int|null $elementos_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filtro newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filtro newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filtro query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filtro whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filtro whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filtro whereParteDelCuerpo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filtro whereUpdatedAt($value)
 */
	class Filtro extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $tipo
 * @property string $titulo
 * @property string $mensaje
 * @property int|null $solicitud_id
 * @property int|null $pedido_id
 * @property int|null $usuario_accion_id
 * @property bool $leida
 * @property \Illuminate\Support\Carbon|null $fecha_lectura
 * @property bool $correo_enviado
 * @property \Illuminate\Support\Carbon|null $fecha_envio_correo
 * @property array<array-key, mixed>|null $datos_adicionales
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pedido|null $pedido
 * @property-read \App\Models\Solicitud|null $solicitud
 * @property-read \App\Models\User $usuario
 * @property-read \App\Models\User|null $usuarioAccion
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notificacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notificacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notificacion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notificacion whereCorreoEnviado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notificacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notificacion whereDatosAdicionales($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notificacion whereFechaEnvioCorreo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notificacion whereFechaLectura($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notificacion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notificacion whereLeida($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notificacion whereMensaje($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notificacion wherePedidoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notificacion whereSolicitudId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notificacion whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notificacion whereTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notificacion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notificacion whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notificacion whereUsuarioAccionId($value)
 */
	class Notificacion extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $fecha
 * @property int|null $users_id
 * @property int|null $fichas_id
 * @property string|null $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ElementoPP> $elementos
 * @property-read int|null $elementos_count
 * @property-read \App\Models\Ficha|null $ficha
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Solicitud> $solicitudes
 * @property-read int|null $solicitudes_count
 * @property-read \App\Models\User|null $usuario
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereFichasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pedido whereUsersId($value)
 */
	class Pedido extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nombre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permiso newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permiso newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permiso query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permiso whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permiso whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permiso whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permiso whereUpdatedAt($value)
 */
	class Permiso extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nombre
 * @property int|null $areas_id
 * @property string $nivel
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Area|null $area
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ficha> $fichas
 * @property-read int|null $fichas_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programa query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programa whereAreasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programa whereNivel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programa whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Programa whereUpdatedAt($value)
 */
	class Programa extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nombre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permiso> $permisos
 * @property-read int|null $permisos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pedido> $pedidos
 * @property-read int|null $pedidos_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solicitud newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solicitud newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solicitud query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solicitud whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solicitud whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solicitud whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Solicitud whereUpdatedAt($value)
 */
	class Solicitud extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nombre_completo
 * @property string $email
 * @property string $password
 * @property int|null $roles_id
 * @property int|null $areas_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Area|null $area
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pedido> $pedidos
 * @property-read int|null $pedidos_count
 * @property-read \App\Models\Role|null $rol
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAreasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNombreCompleto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRolesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

