var Dase = {};

$(document).ready(function() {
	Dase.initDelete('topMenu');
	Dase.initDelete('filters');
	Dase.initDelete('sorters');
	Dase.initDelete('node_meta');
	Dase.initToggle('target');
	Dase.initToggle('email');
	Dase.initToggle('content');
	Dase.initToggle('attributes');
	Dase.initSortable('target');
	Dase.initUserPrivs();
	Dase.initFormDelete();
	Dase.initFormPut();
	Dase.initAttachmentForm();
	Dase.initAttvalForm();
	Dase.initPreviewForm();
});

Dase.initPreviewForm = function() {
	$('#preview_form').submit(function() {
		$.ajax({
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function(data) { $('#preview').html(data); },
		});
		return false;
	});
};

Dase.initAttvalForm = function() {
	$('select[name="att_ascii"]').change(function() {
		$('select option:selected').each(function() {
			var att_ascii = $(this).attr('value');
			$.get('attribute/'+att_ascii+'/defined', function(data) {
				if (data) {
					$('input[name="value"]').hide();
					$('select[name="defined_value"]').html(data).show();
				} else {
					$('select[name="defined_value"]').hide();
					$('input[name="value"]').show();
				}
			});
		});
	});
};

Dase.initAttachmentForm = function() {
	$('select[name="child_type"]').change(function() {
		$('select option:selected').each(function() {
			var child_type = $(this).text();
			if ('node' == child_type) {
				$.get('node/select_list', function(data) {
					$('select[name="child_id"]').html(data);
					$('select[name="child_id"]').show();
				});
			}
			if ('nodeset' == child_type) {
				$.get('nodeset/select_list', function(data) {
					$('select[name="child_id"]').html(data);
					$('select[name="child_id"]').show();
				});
			}
			if ('url' == child_type) {
				$('input[name="child_name"]').show();
			}
			$('#attachment_submit').show();
		});
	});
};

Dase.initToggle = function(id) {
	$('#'+id).find('a[class="toggle"]').click(function() {
		var id = $(this).attr('id');
		var tar = id.replace('toggle','target');
		$('#'+tar).toggle();
		return false;
	});	
};

Dase.initFormDelete = function() {
	$("form[method='delete']").submit(function() {
		if (confirm('are you sure?')) {
			var del_o = {
				'url': $(this).attr('action'),
				'type':'DELETE',
				'success': function() {
					location.reload();
				},
				'error': function() {
					alert('sorry, cannot delete');
				}
			};
			$.ajax(del_o);
		}
		return false;
	});
};

Dase.initFormPut = function() {
	$("form[method='put']").submit(function() {
		var put_o = {
			'url': $(this).attr('action'),
			//couldn't get proper data w/ PUT
			'type':'POST',
			'data':$(this).serialize(),
			'success': function() {
				location.reload();
			},
			'error': function() {
				alert('sorry, cannot update');
			}
		};
		$.ajax(put_o);
		return false;
	});
};

Dase.initDelete = function(id) {
	$('#'+id).find("a[class='delete']").click(function() {
		if (confirm('are you sure?')) {
			var del_o = {
				'url': $(this).attr('href'),
				'type':'DELETE',
				'success': function(resp) {
					if (resp.location) {
						location.href = resp.location;
					} else {
						location.reload();
					}
				},
				'error': function() {
					alert('sorry, cannot delete');
				}
			};
			$.ajax(del_o);
		}
		return false;
	});
};

Dase.initSortable = function(id) {
	$('#'+id).sortable({ 
		cursor: 'crosshair',
		opacity: 0.6,
		revert: true, 
		start: function(event,ui) {
			ui.item.addClass('highlight');
		},	
		stop: function(event,ui) {
			$('#proceed-button').addClass('hide');
			$('#unsaved-changes').removeClass('hide');
			$('#'+id).find("li").each(function(index){
				$(this).find('span.key').text(index+1);
			});	
			ui.item.removeClass('highlight');
		}	
	});
};

Dase.initUserPrivs = function() {
	$('#user_privs').find('a').click( function() {
		var method = $(this).attr('class');
		var url = $(this).attr('href');
		var _o = {
			'url': url,
			'type':method,
			'success': function(resp) {
				alert(resp);
				location.reload();
			},
			'error': function() {
				alert('sorry, there was a problem');
			}
		};
		$.ajax(_o);
		return false;
	});
};

